<?php
// Nombre de este archivo para excluirlo del listado
$current_file = basename(__FILE__);

// Obtener todos los archivos del directorio actual
$files = scandir('.');

// Configuración
$exclude_files = ['.', '..', $current_file]; // Archivos a excluir
$title = "Índice de Archivos"; // Título de la página
$project_name = "Mi Proyecto"; // Nombre de tu proyecto

// Filtrar archivos
$filtered_files = array_diff($files, $exclude_files);

// Ordenar alfabéticamente
sort($filtered_files);

// Función para formatear el tamaño del archivo
function format_size($size) {
    if ($size == 0) return '0 bytes';
    if ($size < 1024) return $size . ' bytes';
    if ($size < 1048576) return round($size / 1024, 2) . ' KB';
    return round($size / 1048576, 2) . ' MB';
}

// Función para obtener el tamaño de una carpeta (recursivo)
function folder_size($path) {
    $total_size = 0;
    $files = scandir($path);
    
    foreach($files as $file) {
        if ($file != '.' && $file != '..') {
            $filepath = $path.'/'.$file;
            if (is_dir($filepath)) {
                $total_size += folder_size($filepath);
            } else {
                $total_size += filesize($filepath);
            }
        }
    }
    
    return $total_size;
}

// Iniciar HTML
echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>$title - $project_name</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css'>
    <style>
        :root {
            --primary-color: #4a6fa5;
            --secondary-color: #166088;
            --folder-color: #6c757d;
            --background-color: #f8f9fa;
            --card-bg: #ffffff;
            --text-color: #333333;
            --text-light: #6c757d;
            --border-color: #e9ecef;
            --success-color: #28a745;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background-color: var(--background-color);
            color: var(--text-color);
            margin: 0;
            padding: 20px;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }
        
        h1 {
            color: var(--primary-color);
            margin-bottom: 10px;
        }
        
        .subtitle {
            color: var(--text-light);
            font-size: 1.1rem;
        }
        
        .file-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }
        
        .file-card {
            background-color: var(--card-bg);
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.2s, box-shadow 0.2s;
            border-left: 4px solid var(--primary-color);
            display: flex;
            flex-direction: column;
        }
        
        .file-card.folder {
            border-left-color: var(--folder-color);
        }
        
        .file-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .file-name {
            font-weight: 600;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            flex-grow: 1;
        }
        
        .file-name a {
            color: var(--secondary-color);
            text-decoration: none;
            margin-left: 8px;
            word-break: break-all;
        }
        
        .file-name a.folder-link {
            color: var(--folder-color);
        }
        
        .file-name a:hover {
            text-decoration: underline;
            color: var(--primary-color);
        }
        
        .file-name a.folder-link:hover {
            color: var(--folder-color);
            opacity: 0.8;
        }
        
        .file-icon {
            color: var(--primary-color);
            font-size: 1.2rem;
            min-width: 20px;
        }
        
        .folder-icon {
            color: var(--folder-color);
        }
        
        .file-details {
            font-size: 0.85rem;
            color: var(--text-light);
            margin-top: 10px;
        }
        
        .file-details span {
            display: block;
            margin-bottom: 3px;
        }
        
        .file-size::before {
            content: '📦 ';
            font-weight: 600;
        }
        
        .file-date::before {
            content: '🕒 ';
            font-weight: 600;
        }
        
        .file-count {
            color: var(--success-color);
        }
        
        .file-count::before {
            content: '🗂 ';
            font-weight: 600;
        }
        
        footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        @media (max-width: 600px) {
            .file-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class='container'>
        <header>
            <h1><i class='fas fa-folder-open'></i> $title</h1>
            <p class='subtitle'>Directorio actual: " . basename(dirname(__FILE__)) . "</p>
        </header>
        
        <div class='file-grid'>";

// Generar tarjetas de archivos
foreach ($filtered_files as $file) {
    $file_path = './' . $file;
    $file_date = date("Y-m-d H:i:s", filemtime($file_path));
    $file_extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    $is_dir = is_dir($file_path);
    
    // Determinar icono y clase CSS
    $icon = 'fa-file';
    $card_class = '';
    $link_class = '';
    
    if ($is_dir) {
        $icon = 'fa-folder';
        $card_class = 'folder';
        $link_class = 'folder-link';
        $file_size = format_size(folder_size($file_path));
        $file_count = count(glob($file_path . "/*")) . ' elementos';
    } else {
        $file_size = format_size(filesize($file_path));
        $file_count = '';
        
        // Asignar iconos según extensión
        switch ($file_extension) {
            case 'php': $icon = 'fa-file-code'; break;
            case 'jpg': case 'jpeg': case 'png': case 'gif': case 'svg': 
                $icon = 'fa-file-image'; break;
            case 'pdf': $icon = 'fa-file-pdf'; break;
            case 'doc': case 'docx': $icon = 'fa-file-word'; break;
            case 'xls': case 'xlsx': $icon = 'fa-file-excel'; break;
            case 'zip': case 'rar': case 'tar': case 'gz': 
                $icon = 'fa-file-archive'; break;
            case 'mp3': case 'wav': case 'ogg': $icon = 'fa-file-audio'; break;
            case 'mp4': case 'avi': case 'mov': $icon = 'fa-file-video'; break;
            case 'txt': case 'log': $icon = 'fa-file-alt'; break;
        }
    }
    
    // Construir enlace
    $link_content = "<i class='fas $icon " . ($is_dir ? 'folder-icon' : '') . "'></i> $file";
    $link = $is_dir 
        ? "<a href='$file/' class='$link_class'>$link_content</a>"
        : "<a href='$file'>$link_content</a>";
    
    echo "<div class='file-card $card_class'>
            <div class='file-name'>
                $link
            </div>
            <div class='file-details'>
                <span class='file-size'>$file_size</span>";
    
    if ($is_dir) {
        echo "<span class='file-count'>$file_count</span>";
    }
    
    echo "<span class='file-date'>$file_date</span>
            </div>
          </div>";
}

// Cerrar HTML
echo "</div>
        <footer>
            <p>Generado automáticamente el " . date('Y-m-d H:i:s') . "</p>
            <p><i class='fas fa-info-circle'></i> Total: " . count($filtered_files) . " elementos</p>
        </footer>
    </div>
</body>
</html>";
?>