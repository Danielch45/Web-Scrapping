<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data;

class DataController extends Controller
{
	private function getLink()
	{
		$file = fopen("List_Website.csv", 'r');

		while(!feof($file))
		{
			$link[] = fgetcsv($file, 0, ',');
			//fgetcsv returnnya array rownya	
		}

		fclose($file);

		return $link;
	}

	private function scrapData($url)
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		return curl_exec($ch);
	}

	public function addData()
	{
		$link = $this->getLink();
		$len = sizeof($link);
		for ($i=0; $i < $len-1; $i++)//index terakhir itu bool false 
		{ 
			$output = $this->scrapData($link[$i][0]);

			$dom = new \DOMDocument;

			libxml_use_internal_errors(true);
			$dom->loadHTML($output);
			libxml_use_internal_errors(false);

			$xpath = new \DOMXpath($dom);

			$newsDate = $xpath->query("//item/pubdate")[0]->nodeValue;
			$newsDate= date("Y-m-d H:i:s", strtotime($newsDate));
			// 

			$xml = new \SimpleXMLElement($output);
			$var =  (string)$xml->channel->item[0]->description;
			$imgLink = explode("\"", $var)[1];
			$newsTitle = (string)$xml->channel->item[0]->title;
			// $newsDate = (string)$xml->channel->item[0]->pubdate;
			// $newsDate= date("Y-m-d H:i:s", strtotime($newsDate));
			$source = explode(".", $link[$i][0])[1];

			$newsLink = (string)$xml->channel->item[0]->link;
			// echo $imgLink[1];
			// return;
			Data::create([
				'title' => $newsTitle,
				'imageLink' => $imgLink,
				'pubdate' => $newsDate,
				'source' => $source,
				'newsLink' => $newsLink,
			]);
		}

		return redirect('/');
	}

	public function viewData()
	{
		$datas = Data::orderBy('pubdate', 'desc')->get();
		if(count($datas) == 0)
		{
			return redirect('importData');
		}
		$link = $this->getLink();
		unset($link[sizeof($link)-1]);
		for ($i=0; $i < sizeof($link); $i++) { 
			$sources[] = explode(".", $link[$i][0])[1];
		}
		return view('feeds')->with(['datas' => $datas, 'sources' => $sources]);
	}
}
