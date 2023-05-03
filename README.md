# Symfony 6.2 with Docker
This is based from [Symfony docs](https://symfony.com/doc/current/setup/docker.html) and [Symfony-docker](https://github.com/dunglas/symfony-docker).

## Commands

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --pull --no-cache` to build fresh images
3. Run `docker compose up` (the logs will be displayed in the current shell)
4. Run `docker exec -it mapping-file-database-php-1 sh` (to open the shell)
5. Run `docker compose down --remove-orphans` to stop the Docker containers.
6. To run the tests ` docker exec -it mapping-file-database-php-1 php bin/phpunit tests/`
## Request explanation

There is a [Sample Postman collection](Sample.postman_collection.json) with the requests.

#### Uploading the file

<details><summary><code>POST</code><code><b>/api/upload-file</b></code><code>(upload the file with the header to mapped and values)</code></summary>

##### body

> | name   |  type  | data type           | description         |
> |--------|-----------|---------------------|---------------------|
> | `file` |  required | file (csv,xlsx,ods) | The file with the data |


##### Responses

> | http code     | content-type        | response                                                            |
> |---------------|---------------------|---------------------------------------------------------------------| 
> | `200`         | `application/json`  | `"file_path": "file_identifier","file_headers": [],"user_fields": []`|
> | `400`         | `application/json`  | `{"code":"400","message":""}`                            |

</details>


#### Map the columns

<details><summary><code>POST</code><code><b>/api/mapping</b></code><code>(the mapping object)</code></summary>

##### body

> | name   |  type  | data type           | description                                                                                                                      |
> |--------|-----------|----------------------------------------------------------------------------------------------------------------------------------|---------------------|
> | `file_path` |  required | string | The file identifier returned in the upload-file request                                                                          |
> | `object_type` |  required | string | The object identifier related to the file data                                                                                   |
> | `mapping` |  required | array | Array of column_name (name in database) and property_name (name in file): <code>[{"column_name": "","property_name": ""}]</code> |


##### Responses

> | http code     | content-type        | response                                          |
> |---------------|---------------------------------------------------|---------------------------------------------------------------------| 
> | `200`         | `application/json`  | `Array [{}] with the objects and values imported` |
> | `400`         | `application/json`  | `{"code":"400","message":""}`                     |

</details>

## License

Symfony Docker is available under the MIT License.

## Credits

Created by [Kévin Dunglas](https://dunglas.fr), co-maintained by [Maxime Helias](https://twitter.com/maxhelias) and sponsored by [Les-Tilleuls.coop](https://les-tilleuls.coop).
