<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class DocViewerAPI extends Controller
{
    public $client;
    private $extentionsMap=array("jpeg"=>"images","jpg"=>"images","pdf"=>"pdfs","tif"=>"images","PNG"=>"images","png"=>"images");

    public function __construct(\Solarium\Client $client)
    {
        $this->client = $client;
    }

    public function ping()
    {
        // create a ping query
        $ping = $this->client->createPing();

        // execute the ping query
        try {
            $this->client->ping($ping);
            return response()->json('OK');
        } catch (\Solarium\Exception $e) {
            return response()->json('ERROR', 500);
        }
    }
    public function detail(Request $request)
    {
        $id = $request->input('id');
        if (strpos($id, '.pdf') !== false) {
            //get contents from solr
        }
        else
        {
            $responseData=array("imageSrc"=>"/".$id,"fromtTopLefX"=>"13","fromtTopLefY"=>"13",);
            return $responseData;
        }

    }
    public function search(Request $request)
    {
        
        $filter = json_decode($request->input('pq_filter'));
		//print_r($filter);
		//return 1;
		
        // if(array_key_exists())
        //if(gettype($filter)=="object"&&property_exists("dataIndx",$filter->data[0]))
		if(gettype($filter)=="object"&&strlen($filter->data[0]->value)>0)
        {
        $srchField=$filter->data[0]->dataIndx;
        $srchValue=$filter->data[0]->value;
        // return ($filter->data[0]->dataIndx);
        }
        else
        {
            $srchField="content";
            $srchValue="*";
       
        }
        $ch = curl_init(); 
        $testURl="127.0.0.1:8983/solr/ocr/select?q=content:".urlencode ($srchValue).("&fl=id,last_modified,title,author,highlighting&hl.fl=content&hl=on&hl.fragsize=0&wt=php");
      //     echo $testURl;    
       // set url 
        curl_setopt($ch, CURLOPT_URL,$testURl); 

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch); 
        if (curl_errno($ch)) {
            return "{}";
            array(array("id"=>"pdf1.pdf"),array("id"=>"img1.png"),array("id"=>"img2.jpg"),array("id"=>"pdf2.pdf"));
        }

        eval("\$output = " . $output . ";");

        // close curl resource to free up system resources 
        curl_close($ch);
        $responseArr;
        foreach ($output["response"]["docs"] as $key => $value) {
            $value["content"]=$output["highlighting"][$value["id"]]["content"][0];
            $responseArr[]=($value);
            // echo"<br>";
        }
        //    print_r ($output["highlighting"]);
        return ($responseArr);
        //     $query = $this->client->createSelect();
        //     // $query->addFilterQuery(array('key'=>'provence', 'query'=>'provence:Groningen', 'tag'=>'include'));
        //     // $query->addFilterQuery(array('key'=>'degree', 'query'=>'degree:MBO', 'tag'=>'exclude'));
        //     // $facets = $query->getFacetSet();
        //     // $facets->createFacetField(array('field'=>'degree', 'exclude'=>'exclude'));
        //      $resulset = $this->client->select($query);
        //     echo $resultset;
        //     // display the total number of documents found by solr
        //     // echo 'NumFound: ' . $resultset->getNumFound();

        //     // show documents using the resultset iterator
        //     /*foreach ($resultset as $document) {

        //         echo '<hr/><table>';

        //         // the documents are also iterable, to get all fields
        //         foreach ($document as $field => $value) {
        //             // this converts multivalue fields to a comma-separated string
        //             if (is_array($value)) {
        //                 $value = implode(', ', $value);
        //             }

        //             echo '<tr><th>' . $field . '</th><td>' . $value . '</td></tr>';
        //         }

        //         echo '</table>';
        //     }*/
    }
    public function down (Request $request)
    {
        $name = $request->get("fileName");
        $file = "/app/files/".$name;
        //echo $file;
        $headers = array('Content-Type' => 'image/jpeg');

    // $header = array(
    //     'Content-Type' => 'application/octet-stream',
    //     'Content-Disposition' => 'attachment', 
    //     'Content-lenght' => filesize($file),
    //     'filename' => $name,
    // );
    $rspns=response()->download(storage_path($file));
    ob_end_clean();

    // auth code
    return $rspns;
    }
    public function up(Request $request)
    {   
        $files=[];
        foreach ($request->files as $file) {
            $uploadedFile = $file[0];
            // print_r ($file);//["describtion"];
            $filename = time().$uploadedFile->getClientOriginalName();
            $fileExtention =substr($filename,strrpos ($filename ,".")+1);
            $fileExtention= $this->extentionsMap[strtolower($fileExtention)];

            // print_r ( $filename);
            Storage::disk('local')->putFileAs(
                'files/'.$fileExtention,
                $uploadedFile,
                $filename
            );
        }
		//http://localhost:8080/extract?path=samples/D1.tif
		$app_path="C:/xampp/htdocs/ocr_front";
		$file_path=$app_path."/storage/app/files/".$fileExtention."/".$filename;
		$backEndUrl='http://localhost:8080/extract?path='.$file_path;
		//curl start
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL,$backEndUrl); 

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch); 
        if (curl_errno($ch)) {
            return "{}";
        }	
		
        return response()->json([
          'fileLocation' => $backEndUrl
        ]);
    }
}