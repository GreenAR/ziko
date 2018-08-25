<?php
/**
 * Created by PhpStorm.
 * User: green
 * Date: 25/08/18
 * Time: 04:22
 */

namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;


class UserController
{

    public function usersAction(Request $request)
    {

        $limit = $request->query->get('limit');
        $offset = $request->query->get('offset');
        $name = $request->query->get('name');


        $data_dir=realpath(__DIR__ . '/../../data');
        $finder = new Finder();
        $finder->files()->in($data_dir);
        $array = iterator_to_array($finder);
        $file=reset($array);
        $json_file_array = json_decode($file->getContents(), true);


        if (!empty($offset)) {
            $json_file_array=array_slice($json_file_array,$offset);

            if (!empty($limit)) {
                $json_file_array=array_slice($json_file_array,0,$limit);
            }
        }
        if (!empty($name)) {
            //filter by name
        }

        var_dump(sizeof($json_file_array));
        $response = new Response();
        $response->setContent(json_encode($json_file_array));
        $response->headers->set("Content-Type", "application/json");

        return $response;
    }
}