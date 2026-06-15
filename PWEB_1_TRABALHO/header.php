<!doctype html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Grão de Ouro - Sistema</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <link   rel="stylesheet" 
                href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" 
                integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" 
                crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        
        <style>
            .wrapper-back-coffee {
                position: fixed !important;
                top: 20px !important;
                left: 20px !important;
                z-index: 9999 !important;
            }

            .btn-back-coffee {
                background-color: #2a0810 !important;
                color: #E8BC73 !important;
                border: 1px solid #D4A35D !important;
                font-weight: 500;
                transition: all 0.3s ease;
                text-decoration: none;
            }
            .btn-back-coffee:hover {
                background-color: #D4A35D !important;
                color: #37070E !important;
                transform: translateY(-2px);
            }
        </style>
    </head>
  
    <?php
    session_start();
    
    function redirect($page){
        header("Location: $page");
        exit;
    }

    function actionMessage($success, $error){
        if(!empty(trim($success))){
            echo " <div class='alert alert-success border border-success' role='alert'><i class='bi bi-check-circle-fill me-2'></i><strong>$success</strong></div>";
        }
        if(!empty(trim($error))){
            echo " <div class='alert alert-danger border border-danger' role='alert'><i class='bi bi-exclamation-triangle-fill me-2'></i><strong>$error</strong></div>";
        }
    }

    function showValidationError($errors = []){
        if (!empty($errors)) {
            echo "<div class='alert alert-danger' role='alert'><ul>";
            echo "<strong><i class='bi bi-x-circle-fill me-2'></i>Erros nos campos:</strong>";
           
            foreach ($errors as $error) {
                echo $error;
            }
            echo "</ul></div>";
        }
    }

    function getFormValue($data, $campo) {
        if (is_object($data)) return htmlspecialchars($data->$campo ?? '');
        if (is_array($data)) return htmlspecialchars($data[$campo] ?? '');
        return '';
    }
    ?>

       