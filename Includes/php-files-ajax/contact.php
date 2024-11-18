<?php
	
    include '../functions/functions.php';
    
	if(isset($_POST['contact_name']) && isset($_POST['contact_email']) && isset($_POST['contact_subject']) && isset($_POST['contact_message']))
	{
		
		$contact_name = test_input($_POST['contact_name']);
        $contact_email  = test_input($_POST['contact_email']);
        $contact_subject = test_input($_POST['contact_subject']);
        $contact_message = test_input($_POST['contact_message']);
        
        $mail = mail("Email", $contact_subject, $contact_message);

        if($mail)
        {
            ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    A mensagem foi enviadda com sucesso!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php
        }
        else
        {
            ?>

                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Ocorreu um problema ao enviar a mensagem, por favor, tentem novamente!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

            <?php
        }

	}

?>