<?php

if ($_POST['token'] == 'as23rlkjadsnlkcj23qkjnfsDKJcnzdfb3353ads54vd3favaeveavgbqaerbVEWDSC') {
    include('connection.php');

    $sql = "SELECT * FROM `departments`";
    $execute = mysqli_query($conn, $sql);

    if ($execute) {
        if (mysqli_num_rows($execute) > 0) {
            $departments = [];
            while ($row = mysqli_fetch_assoc($execute)) {
                $departments[] = $row;
            }

            echo json_encode([
                "status" => true,
                "Message" => "Abteilungen erfolgreich abgerufen.",
                "english_message" => "Departments fetched successfully.",
                "data" => $departments
            ]);
        } else {
            echo json_encode([
                "status" => false,
                "Message" => "Keine Abteilungen gefunden.",
                "english_message" => "No departments found.",
                "data" => []
            ]);
        }
    } else {
        echo json_encode([
            "status" => false,
            "Message" => "Fehler bei der Datenbankabfrage.",
            "english_message" => "Database query error.",
            "error" => mysqli_error($conn)
        ]);
    }

} else {
    echo json_encode([
        "status" => false,
        "Response_code" => 403,
        "Message" => "Zugriff verweigert.",
        "english_message" => "Access denied."
    ]);
}

?>
