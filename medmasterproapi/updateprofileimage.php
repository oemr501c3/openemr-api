<?php

header("Content-Type:text/xml");
$ignoreAuth = true;
require('classes.php');

$xml_array = array();

$token = $_POST['token'];
$patientId = $_POST['patientId'];
$image_data = isset($_POST['image_data']) ? $_POST['image_data'] : '';

//$token = 'f12dab7305cd43b68db8551008f9f9a6';
//$patientId = 1;
//$image_data = '/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBg8QEA8PDRAPDgwNEA0ODQ4MDRAODA8PFBAVFBQQEhIXGyYeFxkvGRQSHy8gIycpLCwsFR4yNTAqNSYrLCkBCQoKDgwOGA8PGiklHCQvKTApKS4pKSkqKiw1LCwpMC01KTUsKi01KSksLCkqKjUpNDQ1LC8tLzU1NSkpKTUpKf/AABEIAJUAlAMBIgACEQEDEQH/xAAcAAABBQEBAQAAAAAAAAAAAAAAAQQFBgcCAwj/xABBEAABAgIDDAgDBgYDAAAAAAABAAIDEQQT0QUGEiExQVFSU2FxkgcUFhcyNJOyI3KRJIGiscHhFSIzNWKhQkNj/8QAGgEAAgMBAQAAAAAAAAAAAAAAAAIBAwQFBv/EADYRAAIBAgQCBwUHBQAAAAAAAAABAgMRBBITMQUhIjJBUaHR4RQWU2GxBhVSgZHw8SNEcZLB/9oADAMBAAIRAxEAPwDbosUNEzkCql0ukugQHmHEjww9uItBLiDoOCDIo6S7pPgUGkPhHBeIZDSMoJIbMfVfOI35c808Y3ElKx9B97Vztu3lfYjvZudt28r7FgAC6AT6aE1Gb73sXP27eV9iXvXuft28r7FggC7AU6SI1Wbx3rXP2zeV9iXvVoG2byvsWEALoBTpIjVZuverQNs3lfYjvUoG2byvsWFyXQCNJEarNz71KBtm8r7Ed6dA2zeV9iw0BLJTooNZm496dA2zeV9iO9OgbZvK+xYfJEkaKDWZuHelQNs3lfYjvSoO2b9H2LEJIkjRQazNxHSlQNs36PsVguRfBApLQ6C9r2nO0z+5fN8la+jenPh01rGk4EVrsJuabRMHjallSSV0NGq27M3lC5hmYCRUF5SOlv8At9I+Qe9q+f2hfQPSz/b6R8o97VgLWq6nsU1Nz0hQHO8LXOllwWk/kvUUSJqP5HWK4dHPhpPGD+T1clxcXxh4etKlkva3O/yv3GaU7OxkAokTUfyOsXQor9R/I6xa6hZveB/D8fQXUMkFFfqP5HWLoUV+o/kdYtZQj3hl8Px9CM5k4or9R/I6xcYKvt9V26llVDPxogxkHGxmnjoUZe7es2I0RqRMsdjZDyYQ1nHRuXUpcT/oa9aOVdivdv6DZuVyrSSyWowrnQWiTYUMDcxq76pD1GcjbFhf2hh2U3+voLnMskiS1PqkPUZyNsR1WHqM5G2KPeGPw/H0DMZZJLJal1WHqM5G2I6rD1GcjbEe8Mfh+PoGYy6SsF4fn4PCJ7VJX4mG2CxjWtD3vmMFoBk3Lk4hR14Y+3weET2rs4XFe1UNXLbcspu7RvsDwjghEDwjghQbil9LHkKR8o97VgjWre+lfyEf5R72rCGtV1PYoqbk3e3fCKIIgMMxKwsOJwbLBnu3qbF/42DvVFiprWrsBZavDcNWm5zjdv5vzKGky4dvRsD6gsTq5t9hjxGw2QDN2UmIJNbnccSpDWEkACZOIAZSVer36A2jw8f9Z8i86NDQuVxHC4LCUrqPSe3N/rv2CSSRPpndS6TaPDMR2PMxudzswQ+mgAkkAATJOQBUi7d1TSIk/wDrZMQ27tY7yuRw3AvFVefVW/l+YiVxuwupEdtYZujRGhx4mWL7lpLGgAAYgAABoAWXAJxRaPFiHBh4TjnxmQ3k5l6biPD1iFF51GMV3cvqh2rmlzRNUmHezFI/mitadALiu+zD9u36PXnHgsIv7hf6vzEsi5zRNUzsw/bj6PTenXEfCYYhih0pCQwgTMyTQwGGnJRjX5vbovzCyL3NNKddWDBBMR4BzNBm88As7wzpP1K5kupD7PRT6dS6+St/1jZR5de6bqRELziaP5WN1W2qSvFH26Dwie1QMlP3jeeg8IntXoVTjTp5IqySLYdZG9QPCOCEQPCOCFlNpTOlXyMf5R72rC2tW69KfkY3yj3hYe1qvpbGeruI1q7DUrWqTuPcoxn4x8Nki86dDU1WrGjBznsihs9ri0GREVw+QH3Kb6ydCcCiSxAYhkTC69IEJsh/Uf4dw1l4qrOWPr7c3su5fvcTcjrs3TLvhNyf8yDl3KIku5JcFeywuGhhqapw/ljJWOWtVloLRCYGgY8rjnJVfguwXNcRMNIMtMlK/wAcGz/F+y53FqFeuowpq67eaQPmSfWToP1R1k6Coz+OjZ/i/ZH8cGz/ABfsuD90Yj8HivMXKSnWjoKibt07CAhjMcJ36BeUe7LyJNaGb8rlHnHlyldXh3CZUqiq1eVtluSoo5kiSWSWS9GMcyU9eP56Dwie1QclO3keeg8H+1LPqsaHWRvEDwjghEDwjghYjaU7pR8lG+Ue4LE2tW29J3ko3Ae4LF2sWmlsZq256UOiOivaxgm5x+4DOSr3QaC2ExrG5BlOdxzkplcG5NSzCePivGP/ABGqpaS8fxbH+0T04Porxff5GWTuc4KhqXe5WvL3xTN3+AkBmAxqbQuZQxNSg81N2f8AhC3K92SbtTyC1L2SbtTyC1WBItn3ti/x+C8ibsolOotXEfDnhYBlOUp4lL3FuCHARIwm042MyTGkprdGDhUtzdaI0HgZK2tkAAJADEBuXZ4lj6lPD04wfSkk2/yX1GbPJlDhtEmsYBuaFH3wYDIDpNaHPLWiQE8sz+Sf0inw4Ym97RunNx4BVS690zHfMTENswxv6neubwzC1a9aNSV8qd232kIj0i6kkXtywSSJJUIASSnbyB9ug8H+1QanbyfOweD/AGpJ9VjQ6yN2geEcEIgeEcELEbSo9Jnk4vAe4LG2tW4X93OdGosVrBNxbiGkgzl/pYpVkTBBBGIg5QVqobMy190e7KS45XOn8xXQpDtZ3MU3DUql4ePcZhx1h2s7mKOsu1ncxTdCj2ePcA46y7WPMUnWXazuYpuUijQj3EiuecKeeeVe1edJ+qblInlTTsB6uIOX914uEkTSFTGOUkQpEskickEIQgAU7eT52Dwf7VBK0dHtznxKW2IAcCEHYTpYpkSA4pJ9Vjw6yNrgeEcELqGJAIWI2nFKwcBxf4QCSqFdG5EKM8vMKGCf/NpP3khXi6Y+DE4fqFW6tPErmQHZmDs4fpssR2Zg7OH6bLFYBCS1SfMJlRXuzMHZw/TZYjsxB2cP0mWKw1SKpGYLFd7MQdnD9JliOzEHZw/SZYrFVIqUZgsV3sxB2cP0mWJOzEDZw/SZYrDVJalGYLFd7MQNnD9JliTsvA2cP0mWKx1KQwlGYmxXey8DZw/SZYk7LwNnD9JlisVUirU3CxXey8DZw/SZYl7LwNnD9JlisNWirRcLFeF7EDZQvSZYrdexDhtFWGNYWibcBoa0jhpTKqT24zJRhwd+SiXNDLkyxIQhVFg3ugPhv4fqoIQ1P0sfyO4KKq0yFYMozSJia66o3euoWI7inOCss1KL3FsNOqt3o6q3eneCkklvLvCw16q3ejqjd6dSRJF5d4WI50EYUs017dUG9dxGYyvZmMb1dPNZNBYaPoeg/VeBgyyqVwV5R4WdRTm72YEdVoqk6q0Va0E2GtUiqTqrRVouFhrVJ1cxkog4O/JFWnFBZJ44FDBEkhCEg55xxNpTOqT9wmFxVIAZ1S9GDMnFUiqQ1cix5YK83wc6dYCMBIlYLDOqRVJ3VoqlZcLDSqSiEU6q0uAobCw2kUFpTnARgJbfILDOqRVJ3gIq01wsNKpFUndUiqUhYaVS9KOyTvqveqStZJAHaEIUEghCEACEIQAIQhAAhCEACEIQAIQhAAhCEACEIQAIQhAAhCEAf//Z';
//$image_data = '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';

if (validateToken($token)) {
    if ($image_data) {

        $id = 1;
        $type = "file_url";
        $size = '';
        $date = date('Y-m-d H:i:s');
        $url = '';
        $mimetype = 'image/png';
        $hash = '';
        $patient_id = $patientId;
        $ext = 'png';
        $cat_title = 'Patient Profile Image';

        $strQuery2 = "SELECT id from `categories` WHERE name LIKE '{$cat_title}'";
        $result3 = $db->get_row($strQuery2);

        if ($result3) {
            $cat_id = $result3->id;
        } else {
            sqlStatement("lock tables categories read");

            $result4 = sqlQuery("select max(id)+1 as id from categories");

            $cat_id = $result4['id'];

            sqlStatement("unlock tables");

            $cat_insert_query = "INSERT INTO `categories`(`id`, `name`, `value`, `parent`, `lft`, `rght`) 
                VALUES ({$cat_id},'{$cat_title}','',1,0,0)";

            sqlQuery($cat_insert_query);
        }


//        $image_path = $_SERVER['DOCUMENT_ROOT'] . "/openemr/sites/default/documents/{$patient_id}";

        $image_path = $sitesDir . "{$site}/documents/{$patient_id}";
        
        echo $image_path;exit;
        
        if (!file_exists($image_path)) {
            mkdir($image_path);
        }

        $image_date = date('Y-m-d_H-i-s');

        file_put_contents($image_path . "/" . $image_date . "." . $ext, base64_decode($image_data));

        $hash = sha1_file($image_path . "/" . $image_date . "." . $ext);

        $url = "file://" . $image_path . "/" . $image_date . "." . $ext;

        $size = filesize($url);

        $strQuery4 = "SELECT d.url,d.id
                                FROM `documents` AS d
                                INNER JOIN `categories_to_documents` AS c2d ON d.id = c2d.document_id
                                WHERE d.foreign_id ={$patient_id}
                                AND c2d.category_id ={$cat_id}
                                ORDER BY category_id, d.date DESC";

        $result4 = $db->get_results($strQuery4);

        if ($result4) {

            $file_path = $result4[0]->url;
            $document_id = $result4[0]->id;
            unlink($file_path);

            $strQuery = "UPDATE `documents` SET 
                                        `size`='{$size}',
                                        `url`='{$url}',
                                        `mimetype`='{$mimetype}',
                                        `hash`='{$hash}'
                                        WHERE id = " . $document_id;

            $result = $db->query($strQuery);

//            $strQueryD = "DELETE FROM `documents` WHERE id =" . $document_id;
//            $resultD = $db->query($strQueryD);
//
//            $strQueryD1 = "DELETE FROM `categories_to_documents` WHERE document_id =" . $document_id;
//            $resultD = $db->query($strQueryD1);
        } else {


            sqlStatement("lock tables documents read");

            $result = sqlQuery("select max(id)+1 as did from documents");

            sqlStatement("unlock tables");

            if ($result['did'] > 1) {
                $id = $result['did'];
            }

            $strQuery = "INSERT INTO `documents`( `id`, `type`, `size`, `date`, `url`, `mimetype`, `foreign_id`, `docdate`, `hash`, `list_id`) 
             VALUES ({$id},'{$type}','{$size}','{$date}','{$url}','{$mimetype}',{$patient_id},'{$docdate}','{$hash}','{$list_id}')";

            $result = $db->query($strQuery);

            $strQuery1 = "INSERT INTO `categories_to_documents`(`category_id`, `document_id`) VALUES ({$cat_id},{$id})";

            $result1 = $db->query($strQuery1);
        }

        if ($result) {
            $xml_array['status'] = 0;
            $xml_array['reason'] = 'The Patient has been updated';
        } else {
            $xml_array['status'] = -2;
            $xml_array['reason'] = 'ERROR: Sorry, there was an error processing your data. Please re-submit the information again.';
        }
    } else {
        $xml_array['status'] = -2;
        $xml_array['reason'] = 'Please select the image';
    }
} else {
    $xml_array['status'] = -2;
    $xml_array['reason'] = 'Invalid Token';
}

$xml = ArrayToXML::toXml($xml_array, 'Patient');
echo $xml;
?>
