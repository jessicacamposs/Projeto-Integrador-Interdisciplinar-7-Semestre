<?php include '../connect.php'; ?>
<?php include '../Includes/functions/functions.php'; ?>

<?php
// Debug: Verifique o conteúdo de $_POST
if (empty($_POST)) {
    echo "POST data is empty!";
} else {
    var_dump($_POST);
}

if (isset($_POST['do']) && $_POST['do'] == "Add") {
    // Código para processar o upload da imagem
    echo "Form submitted correctly!";
} else {
    echo "Form not submitted correctly.";
}
?>


<?php
    if (isset($_POST['do']) && $_POST['do'] == "Add") {
        
        // Sanitização do nome da imagem
        $image_name = test_input($_POST['image_name']);

        // Processamento da imagem
        $image_Name = $_FILES['image']['name'];
        $image_allowed_extension = array("jpeg", "jpg", "png");
        $image_split = explode('.', $image_Name);
        $extension = end($image_split);
        $image_extension = strtolower($extension);
        
        // Validação da imagem
        if (empty($_FILES['image']['name']) || !in_array($image_extension, $image_allowed_extension)) {
            echo "<div class='alert alert-warning'>";
            echo "Invalid Image format! Only JPEG, JPG and PNG are accepted.";
            echo "</div>";
        } else {
            // Verifica erro no upload da imagem
            if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                echo "<div class='alert alert-danger'>Error uploading the image. Please try again.</div>";
                exit;
            }

            try {
                // Gerando nome único para a imagem
                $image = rand(0, 100000) . '_' . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], "Uploads/images/" . $image);

                // Inserindo no banco de dados
                $stmt = $con->prepare("INSERT INTO image_gallery (image_name, image) VALUES (?, ?)");
                $stmt->execute(array($image_name, $image));

                echo "<div class='alert alert-success'>";
                echo "Great! Image has been inserted successfully.";
                echo "</div>";

            } catch (Exception $e) {
                echo "<div class='alert alert-danger'>";
                echo "Error occurred while trying to insert image: " . $e->getMessage();
                echo "</div>";
            }
        }    
    } else {
        echo "Form not submitted correctly.";
    }
?>
