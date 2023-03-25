<?php

namespace App\Services;

use GuzzleHttp\Client;

/**
 * Instagram api class
 */
class InstagramService {

    /**
     * Return current user information, user id & username
     *
     * @return array
     */
    public static function getUserInfo(): array
    {
        $client = new Client();

        try {
            $response = $client->get(
                config('services.instagram.baseUrl') . 'me?fields=id,username&access_token=' . config('services.instagram.token')
            );

            $data = $response->getBody()->getContents();
            $data = json_decode($data);
            return [
                'user_id' => $data->id,
                'username' => $data->username
            ];

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Return a user's pictures id
     *
     * @param string $userId
     * @return array
     */
    private static function getPicturesIdFromUser(string $userId): array
    {
        $client = new Client();

        try {
            $response = $client->get(
                config('services.instagram.baseUrl') . $userId . '/media?access_token=' . config('services.instagram.token')
            );

            $datas = $response->getBody()->getContents();
            $datas = json_decode($datas, true)['data'];

            $cleanIds = [];

            foreach($datas as $data) {
                $cleanIds[] = $data['id'];
            }

            return $cleanIds;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Return a number of user's pictures
     *
     * @param string $userId
     * @param integer|null $limit
     * @return array
     */
    public static function getPicturesFromUser(string $userId, ?int $limit = null): array
    {
        $picturesIds = self::getPicturesIdFromUser($userId);
        $picturesList = [];
        $counter = 0;

        foreach ($picturesIds as $pictureId) if ($limit && ($counter < $limit)) {
            
            $picturesList[] = self::getPicture($pictureId);
            $counter++;
        }

        return $picturesList;
    }

    /**
     * Get a picture with his id
     *
     * @param string $pictureId
     * @return array
     */
    private static function getPicture(string $pictureId): array
    {
        $client = new Client();

        try {
            $response = $client->get(
                config('services.instagram.baseUrl') . $pictureId . '?fields=caption,media_type,media_url,permalink,timestamp,username&access_token=' . config('services.instagram.token')
            );

            $data = $response->getBody()->getContents();
            $data = json_decode($data, true);
            return $data;
            
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}