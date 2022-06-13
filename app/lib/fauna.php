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

    public static function createNewProject(string $userId, string $name, string $description, bool $completed): string | object {
        try {
            $mutation = (new Mutation('createNewProject'))
                ->setArguments(['name' => $name, 'description' => $description, 'completed' => $completed, 'owner_id' => $userId])
                ->setSelectionSet(
                    [
                        '_id',
                        '_ts',
                        'name',
                        'description',
                        'completed'
                    ]
                );
            $result = self::getClient()->runQuery($mutation);
            return $result->getData()->createNewProject;
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getProjectsByUser(string $id): string | array {
        try {
            $gql = (new Query('findProjectsByUserId'))
                ->setArguments(['owner_id' => $id])
                ->setSelectionSet(
                    [
                        '_id',
                        '_ts',
                        'name',
                        'description',
                        'completed',
                        'create_timestamp'
                    ]
                );
            $result = self::getClient()->runQuery($gql);
            return $result->getData()->findProjectsByUserId;
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public static function updateExistingProject(string $projectId, string $name, string $description, bool $completed): string | object {
        try {
            $mutation = (new Mutation('updateSingleProject'))
                ->setArguments(['project_id' => $projectId, 'name' => $name, 'description' => $description, 'completed' => $completed])
                ->setSelectionSet(
                    [
                        '_id',
                        '_ts',
                        'name',
                        'description',
                        'completed'
                    ]
                );
            $result = self::getClient()->runQuery($mutation);
            return $result->getData()->updateSingleProject;
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public static function deleteExistingProject(string $projectId): string | object {
        try {
            $mutation = (new Mutation('deleteSingleProject'))
                ->setArguments(['id' => $projectId])
                ->setSelectionSet(
                    [
                        '_id',
                        '_ts',
                        'name',
                        'description',
                        'completed'
                    ]
                );
            $result = self::getClient()->runQuery($mutation);
            return $result->getData()->deleteSingleProject;
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getSingleProjectByUser(string $projectId): string | object | null {
        try {
            $gql = (new Query('findProjectByID'))
                ->setArguments(['id' => $projectId])
                ->setSelectionSet(
                    [
                        '_id',
                        '_ts',
                        'name',
                        'description',
                        'completed',
                        'create_timestamp'
                    ]
                );
            $result = self::getClient()->runQuery($gql);
            return $result->getData()->findProjectByID;
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }
}


