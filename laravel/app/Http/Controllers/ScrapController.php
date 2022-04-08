<?php

namespace App\Http\Controllers;
use Sunra\PhpSimple\HtmlDomParser;
class ScrapController extends Controller
{
    private  $urlBase="https://www.pdfdrive.com";
    private  $urlBase1="https://www.google.com";
    private  $urlBase2="https://www.bing.com";
    private $urlBase3="https://cse.google.com/cse?cx=aef0edeb9ab5e2185&q=ext%3Apdf";
    public function scrap($name)
    {
       
        $ch = curl_init($this->urlBase."/search?q={$name}&more=true");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $dom = HtmlDomParser::str_get_html($result);

        $listItems = $dom->find(".files-new > ul > li");

        $results = [];
        // get innerHtml of each list li element
        $i=0;
        foreach ($listItems as $item){
        $ii=HtmlDomParser::str_get_html($item);
        $results[$i]=$ii;
        $i++;
        }
       shuffle($results);

        return implode("Mishu", $results);
    }

    public function downloadLink($link)
    {

        $href = '/'.$link.'.html';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->urlBase.$href);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        $domLoaded = HtmlDomParser::str_get_html($result);
        $prevButton=$domLoaded->getElementById('previewButtonMain');
        $allAttr=  $prevButton->attr;
        $dataPreview= $allAttr['data-preview'];
        $z= explode("=", $dataPreview);
        $session = $z[count($z)-1];
        $id=explode("&", $z[1])[0];

        $ur=$this->urlBase."/download.pdf?id={$id}&h={$session}&u=cache&ext=pdf";
        curl_close($ch);

        return $ur;

    }



    public function googlesearch($name){
        $ch = curl_init($this->urlBase1."/search?q=ext%3Apdf+".str_replace("%20", "+", $name));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       $html = curl_exec($ch);
        //   $dom = HtmlDomParser::str_get_html($result);

        $books=array();
        $book=array();
        $urlfor[0]=$this->urlBase3;
        $urlfor[1]=$this->urlBase2;


     // return  $html = curl_exec($ch);
      //  curl_close($ch);




        # Create a DOM parser object
        $dom = new \DOMDocument();
        # Parse the HTML from Google.
        # The @ before the method call suppresses any warnings that
        # loadHTML might throw because of invalid HTML in the page.
        @$dom->loadHTML($html);
        # Iterate over all the <a> tags
        foreach($dom->getElementsByTagName('a') as $link) {
            # Show the <a href>
     

       $href= $link->getAttribute('href');
 


            if(strpos($href, "http")!==false && strpos($href, ".pdf") !==false){ 
        $name= $link->nodeValue;

   //     $domElementXml = $link->ownerDocument->saveXML($link);
    //    echo $domElementXml;
      //     echo "<br />\n";
                $url= substr($href, strpos($href, "http"), strpos($href, ".pdf")-3);
    //echo $url;
   // echo "<br />\n";
                  $bookName = basename($url, ".pdf");
                  $bookName=substr($name, strpos($name, "]"), strpos($name, "›"));
                if(str_contains($url, "webcache.googleusercontent.com")) continue;
                $book=[
                    'bookname'=>$bookName,
                    'url'=>$url
                ];
                //store each book info to array and convert the array to string 
                $book= implode("Mishu616Rahman", $book);
                array_push($books, $book);

            }
        }

        
        // converting all books info to string
        return implode("Tanvir598Ahmed", $books);
        
    }
}
