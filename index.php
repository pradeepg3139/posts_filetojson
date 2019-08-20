<?php
	if ($file = fopen("blogpost.txt", "r")) {
		$content='';
		 $i=-1;
	    while(!feof($file)) {
	        $line = fgets($file);
	       
			if(stripos($line, '---') !== false || stripos($line, 'READMORE') !== false){
					continue;
			}
			else 
			{	
				if(stripos($line, 'title: ') !== false)
				{
					$i=$i+1;
				}       
		        $line= str_replace('"',"",trim($line));
		        
		        if(stripos($line, ': ') !== false) {
		        	
		        	if(stripos($line, 'tags: ') !== false)
		        	{
		        		$key= substr($line,0,strpos($line, ": "));
			        	$value= substr($line,strpos($line, ": ")+1,strlen($line)-1);
						$post_arr[$i][$key]= explode(",",trim($value));
		        	}
		        	else{
					    $key= substr($line,0,strpos($line, ": "));
			        	$value= substr($line,strpos($line, ": ")+1,strlen($line)-1);
						$post_arr[$i][$key]= trim($value);
					}
				}
				else
				{
					if(!array_key_exists("short-content",$post_arr[$i]) && !empty($line))
					{	
						$post_arr[$i]["short-content"]= $line;
					}
					else
						$content.= $line;
					
				}
			}

	    }

	    $post_arr["content"]= $content;
	    // echo "<pre>";
	    // print_r($post_arr);
	    // print_r(stripslashes(json_encode($post_arr))); 
	    fclose($file);

	    $file_name= date('d-m-y').'.json';
	    if(file_put_contents($file_name,json_encode($post_arr)))
	    {
	    	echo $file_name. ' file created.';
	    }
	}
?>