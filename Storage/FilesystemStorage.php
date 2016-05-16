<?php

namespace MagentoHackathon\Toolbar\Storage;

use DebugBar\Storage\StorageInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Directory\ReadInterface;

class FilesystemStorage implements StorageInterface
{
    /** @var Filesystem */
    protected $filesystem;

    protected $dirname = 'toolbar';

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Saves collected data
     *
     * @param string $id
     * @param string $data
     */
    function save($id, $data)
    {
        $directory = $this->filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);

        if ($directory->create($this->dirname)) {
            $path = $this->makeFilename($id);

            $file = $directory->openFile($path);
            try {
                $file->write(json_encode($data));
            } finally {
                $file->close();
            }
        }
    }

    /**
     * Returns collected data with the specified id
     *
     * @param string $id
     * @return array
     */
    function get($id)
    {
        $directory = $this->filesystem->getDirectoryRead(DirectoryList::VAR_DIR);

        return $this->loadFile($directory, $this->makeFilename($id));
    }

    /**
     * Returns a metadata about collected data
     *
     * @param array $filters
     * @param integer $max
     * @param integer $offset
     * @return array
     */
    function find(array $filters = array(), $max = 20, $offset = 0)
    {
        $directory = $this->filesystem->getDirectoryRead(DirectoryList::VAR_DIR);

        $i = 0;
        $results = array();
        foreach ($directory->search('*.json', $this->dirname) as $path)
        {
            if ($i++ < $offset && empty($filters)) {
                $results[] = null;
                continue;
            }

            $data = $this->loadFile($directory, $path);
            $meta = $data['__meta'];
            unset($data);
            if ($this->filter($meta, $filters)) {
                $results[] = $meta;
            }
            if (count($results) >= ($max + $offset)) {
                break;
            }
        }

        return array_slice($results, $offset, $max);
    }

    /**
     * Filter the metadata for matches.
     *
     * @param $meta
     * @param $filters
     * @return bool
     */
    protected function filter($meta, $filters)
    {
        foreach ($filters as $key => $value) {
            if (!isset($meta[$key]) || fnmatch($value, $meta[$key]) === false) {
                return false;
            }
        }
        return true;
    }

    /**
     * Clears all the collected data
     */
    function clear()
    {
        $directory = $this->filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
        $directory->delete($this->dirname);
    }

     /**
      * Create the filename for the data, based on the id.
      *
      * @param $id
      * @return string
      */
    protected function makeFilename($id)
    {
        return $this->dirname . DIRECTORY_SEPARATOR . basename($id) . ".json";
    }

    protected function loadFile(ReadInterface $directory, $path)
    {
        if ($directory->isExist($path)) {
            $file = $directory->openFile($path);

            $contents = '';
            while( ! $file->eof()) {
                $contents .= $file->read(8192);
            }
            return json_decode($contents, true);
        }
    }
}