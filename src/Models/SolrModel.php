<?php

namespace haiderjabbar\laravelsolr\Models;

use Illuminate\Support\Facades\Http;

class SolrModel
{
    /**
     * Generate the Solr URL for the given core name.
     *
     * @param string $coreName
     * @return string
     */
    protected static function getSolrUrl($coreName)
    {
        return config('solr.solr_url') . '/' . $coreName;
    }

    /**
     * Add a new document to Solr.
     *
     * @param string $coreName
     * @param array $data
     * @return bool
     */
    public static function addDocument($coreName, array $data)
    {
        // Ensure $data is always an array of arrays
        $data = isset($data[0]) && is_array($data[0]) ? $data : [$data];

        // Get Solr URL for the core
        $solrUrl = self::getSolrUrl($coreName);

        // Send POST request with JSON data
        $response = Http::withHeaders([
            "Content-Type" => "application/json",
        ])->post("{$solrUrl}/update?commit=true", $data);

        // Return whether the request was successful
        return $response->successful();
    }

    /**
     * Update a document in Solr.
     *
     * @param string $coreName
     * @param array $data
     * @return bool
     */
    public static function updateDocument($coreName, array $data)
    {
        // Ensure $data is always an array of arrays
        $data = isset($data[0]) && is_array($data[0]) ? $data : [$data];

        $solrUrl = self::getSolrUrl($coreName);
        $response = Http::post("{$solrUrl}/update?commit=true", $data);

        return $response->successful();
    }

    /**
     * Delete a document from Solr by ID.
     *
     * @param string $coreName
     * @param string $id
     * @return bool
     */
    public static function deleteDocumentById($coreName, $id)
    {
        $solrUrl = self::getSolrUrl($coreName);
        $deleteQuery = ['delete' => ['*' => "*"]];
        $response = Http::post("{$solrUrl}/update?commit=true", $deleteQuery);
        return $response->successful();
    }

    /**
     * Add child documents to a parent document.
     *
     * @param string $coreName
     * @param string $parentId
     * @param array $childData
     * @return bool
     */
    public static function addChildToParent(string $coreName, string $parentId, string $child = "child", array $childData): bool
    {
        $solrUrl = self::getSolrUrl($coreName);
        $data = [
            [
                'id' => $parentId,

                $child => $childData
            ]
        ];
        $response = Http::post("{$solrUrl}/update?commit=true", $data);
        return $response->successful();
    }
}
