<?php

namespace App\Lib;

use Dotenv\Dotenv;
use Exception;
use GraphQL\Client;
use GraphQL\Query;
use GraphQL\Mutation;
use GraphQL\RawObject;

// load env variables to $_ENV super global
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

define('CLIENT_SECRET', $_ENV['SECRET_KEY']);
define('FAUNA_GRAPHQL_BASE_URL', 'https://graphql.fauna.com/graphql');

class Fauna {
    public static function getClient(): Client {
        return new Client(
            FAUNA_GRAPHQL_BASE_URL,
            ['Authorization' => 'Bearer ' . CLIENT_SECRET]
        );
    }

    public static function getAllUsers(): string | object {
        try {
            $gql = (new Query('all_users'))
                ->setSelectionSet(
                    [
                        (new Query('data'))
                        ->setSelectionSet(
                            [
                                'username'
                            ]
                        )
                    ]
                );
            // Alternative way to write queries but with execute with runRawQuery
            // $gql = <<<QUERY
            // query {
            //     all_users {
            //         data {
            //             username
            //             _ts
            //         }
            //     }
            // }
            // QUERY;
            $result = self::getClient()->runQuery($gql);
            return $result->getData();
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public static function createNewUser(string $username, string $password, int $create_timestamp): string | object {
        try {
            $mutation = (new Mutation('createUser'))
                ->setArguments(['data' => new RawObject('{username: "' . $username . '", password: "' . $password . '", create_timestamp: ' . $create_timestamp . '}')])
                ->setSelectionSet(
                    [
                        '_id',
                        '_ts',
                        'username',
                        'password',
                        'create_timestamp'
                    ]
                );
            $result = self::getClient()->runQuery($mutation);
            return $result->getData()->createUser;
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getUserByUsername(string $username): string | object {
        try {
            $gql = (new Query('findUserByUsername'))
                ->setArguments(['username' => $username])
                ->setSelectionSet(
                    [
                        '_id',
                        '_ts',
                        'username',
                        'password',
                        'create_timestamp'
                    ]
                );
            $result = self::getClient()->runQuery($gql);
            return $result->getData()->findUserByUsername;
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }
}


