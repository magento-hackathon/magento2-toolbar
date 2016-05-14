<?php

namespace MagentoHackathon\Toolbar\Api;
use MagentoHackathon\Toolbar\Exception\RequestDataNotFoundException;

/**
 * Storage for RequestData
 */
interface RequestDataStorageInterface
{
    /**
     * Save
     *
     * Save RequestData into storage and return unique
     * key to retrieve it later
     *
     * @param RequestDataInterface $requestData
     *
     * @return string
     */
    public function save(RequestDataInterface $requestData);

    /**
     * Load RequestData by key
     *
     * @param string $key
     *
     * @return RequestDataStorageInterface
     *
     * @throws RequestDataNotFoundException
     */
    public function load($key);

    /**
     * Get keys for recently stored RequestData
     *
     * @param int $limit Limit
     *
     * @return array
     */
    public function getRecentKeys($limit = 10);

    /**
     * Purge stored RequestData
     *
     * @return void
     */
    public function purge();
}
