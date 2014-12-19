<?php

if ($do == 'api_test') {
    // please fill the following fields to run the demo
    $oauth_consumer_key = "";
    $oauth_consumer_secret = "";
    $this_page = ""; // this is the URL for the demo to get back to this page.
    
/******************************************** DEMO *************************************************/
	$client = new YnoteClient($oauth_consumer_key, $oauth_consumer_secret);

	$response = $client->getRequestToken();
    $request_token = $response['oauth_token'];
	$request_secret = $response['oauth_token_secret'];
	echo '<br />';
	
	$content = $client->getAuthorizeUrl();

    echo "	
	    <html>
		    <body>
			    <form action=\"".$this_page."&do=incomming_test\" method=\"post\" enctype=\"multipart/form-data\">
				    <label for=\"verifier\">Verifier:</label>
				    <input type=\"text\" name=\"verifier\" id=\"verifier\" /> 
				    <br />
                    <label for=\"oauth_request_token\">oauth_request_token:</label>
				    <input type=\"text\" name=\"oauth_request_token\" id=\"oauth_request_token\" /> 
				    <br />
				    <label for=\"oauth_request_secret\">oauth_request_secret:</label>
				    <input type=\"text\" name=\"oauth_request_secret\" id=\"oauth_request_secret\" /> 
				    <br />
				    <input type=\"submit\" name=\"submit\" value=\"Submit\" />
			    </form>
		    </body>
	    </html>";
	
	echo '<a href="'.$content.'" target="_blank">'.$content.'</a>';
	echo '<br />';
	echo $client->toString();
}

if ($do == 'incomming_test') {
	$oauth_verifier = $_POST['verifier'];
    $oauth_request_token = $_POST['oauth_request_token'];
	$oauth_request_secret = $_POST['oauth_request_secret'];
	echo $oauth_verifier;
	echo '<br />';
	echo $oauth_request_secret;

	$client = new YnoteClient($oauth_consumer_key, $oauth_consumer_secret);
	$content = $client->getAccessToken($oauth_request_token, $oauth_request_secret, $oauth_verifier);
	echo '<br />';
    $oauth_access_token = $content['oauth_token'];
    $oauth_access_secret = $content['oauth_token_secret'];

    echo 'access token:'.$oauth_access_token;
    echo '<br />';
    echo 'access secret:'.$oauth_access_secret;
    echo '<br />';

    $user_info_response = $client->getUserInfo($oauth_access_token, $oauth_access_secret);
    echo $user_info_response;

    echo '<br />';
    $list_notebook_response = $client->listNotebooks($oauth_access_token, $oauth_access_secret);
    echo $list_notebook_response;

    echo '<br />';
    $list_notes_response = $client->listNotes($oauth_access_token, $oauth_access_secret, "/CEB7530FFDBD499C94EFFEBC2D8F5F8B");
    echo $list_notes_response;

    echo '<br />';
    $create_notebook_response = $client->createNotebook($oauth_access_token, $oauth_access_secret, "My_new_AA921");
    echo $create_notebook_response;

    echo '<br />';
    $delete_notebook_response = $client->deleteNotebook($oauth_access_token, $oauth_access_secret, "/195BBD9485244F38B488C5BFE9D5A57D");
    echo $delete_notebook_response;

    echo '<br />';
    $create_note_response = $client->createNote($oauth_access_token, $oauth_access_secret, array(
		    'content'	=> "test content".time(),
            'title'     => "test title",
	    ));
    echo $create_note_response;

    echo '<br />';
    $get_note_response = $client->getNote($oauth_access_token, $oauth_access_secret, "/CEB7530FFDBD499C94EFFEBC2D8F5F8B/A76F00FF5D6046B893C60CD603907801");
    echo $get_note_response;

    echo '<br />';
    $delete_note_response = $client->deleteNote($oauth_access_token, $oauth_access_secret, "/5791693DC8FA4706A51F0E174065218D/18C024D408FD403F8F855798F1162D53");
    echo $delete_note_response;

    echo '<br />';
    $update_note_response = $client->updateNote($oauth_access_token, $oauth_access_secret, array(
            'path'      => '/CEB7530FFDBD499C94EFFEBC2D8F5F8B/A76F00FF5D6046B893C60CD603907801',
            'content'   => 'this is the new content of the note, check it out.',
            'title'     =>'my pretty new note(updated)',
        ));
    echo $update_note_response;

    echo '<br />';
    echo '<br />';
    echo '<br />';
    echo '<br />';
    $upload_attachment_response = $client->uploadAttachment($oauth_access_token, $oauth_access_secret, "upload/My_Clippings.txt");
    echo $upload_attachment_response;

    echo '<br />';
    $download_attachment_response = $client->getAuthorizedDownloadLink($oauth_access_token, $oauth_access_secret, "http://note.corp.youdao.com/yws/open/resource/download/6805/8A6ED9B85B1E40A4BFB5135E3FB2A0E9");
    echo '<a href="'.$download_attachment_response.'">Download</a>';
    
    echo '<br />';
    echo 'end of test';
}
?>
