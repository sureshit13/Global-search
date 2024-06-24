
<style>
.display_err{
    margin-top: 0;
    margin-bottom: 1rem;
    background: #000;
    color: white;
    padding: 10px 20px;
}
</style>
<?php
define('ABSPATH', dirname(__FILE__));

// Function to check if all directories exist within a base directory
function checkDirectories($baseDir, $directories) {
    $unavailableDirs = [];

    foreach ($directories as $dir) {
        if (!findDirectory($baseDir, $dir)) {
            $unavailableDirs[] = $dir;
        }
    }

    return $unavailableDirs;
}

// Function to find if a directory exists within a base directory
function findDirectory($baseDir, $dir) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($baseDir), RecursiveIteratorIterator::SELF_FIRST);
    foreach ($iterator as $file) {
        if ($file->isDir() && basename($file) == $dir) {
            return true;
        }
    }
    return false;
}

// Function to recursively search for a term in files within a directory
function search_files($directory, $search_term) {
    $results = array();

    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
    foreach ($iterator as $file) {
        // Skip directories and non-readable files
        if (!$file->isDir() && $file->isReadable()) {
            // Search for the term in the file
            $contents = file_get_contents($file->getPathname());
            $lines = explode("\n", $contents);
            foreach ($lines as $line_number => $line_content) {
                if (strpos($line_content, $search_term) !== false) {
                    $file_path = $file->getPathname();
                    if (!isset($results[$file_path])) {
                        $results[$file_path] = array();
                    }
                    // Store line number only if it's not already stored
                    if (!in_array($line_number + 1, $results[$file_path])) {
                        $results[$file_path][] = $line_number + 1;
                    }
                }
            }
        }
    }

    return $results;
}


// Function to find the line number of a search term in a string
function find_line_number($contents, $search_term) {
    $lines = explode("\n", $contents);
    foreach ($lines as $line_number => $line_content) {
        if (strpos($line_content, $search_term) !== false) {
            return $line_number + 1; // Line numbers are usually 1-based in text editors
        }
    }
    return -1; // Not found
}

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $query = isset($_POST['query']) ? $_POST['query'] : '';
    $directories = isset($_POST['directories']) ? $_POST['directories'] : [];

    // Define the base directory where the search should start (WordPress root)
    $baseDir = ABSPATH;

    // Check if directories are available
    $unavailableDirs = checkDirectories($baseDir, $directories);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Search Results</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Search Results for '<?php echo $query; ?>'</h3>
                    </div>
                    <div class="card-body">
                        <?php 
                        // If there are unavailable directories, display an error message
                        if (!empty($unavailableDirs)) {
                            echo "<div class='alert alert-danger' role='alert'>";
                            echo "The following directories are not available:<br>";
                            echo implode('<br>', $unavailableDirs);
                            echo "</div>";
                        } else {
                            // All directories are available, proceed with search
                            //echo "<div class='alert alert-success' role='alert'>";
                            //echo "All selected directories are available. Proceeding with search for query: '$query'";
                           // echo "</div>";

                            // Perform search in each selected directory
                            $search_results = array();
                            foreach ($directories as $subdir) {

                                $dir_to_search = $baseDir . '/' . $subdir;

                                if ($subdir == 'plugins') {
                                    $dir_to_search = $baseDir . '/wp-content/plugins';
                                } elseif ($subdir == 'themes') {
                                    $dir_to_search = $baseDir . '/wp-content/themes';
                                } elseif ($subdir == 'uploads') {
                                    $dir_to_search = $baseDir . '/wp-content/uploads';
                                }

                                $search_results = array_merge_recursive($search_results, search_files($dir_to_search, $query));
                            }

                            // Output search results
                            if (empty($search_results)) {
                                echo "<div class='alert alert-warning' role='alert'>";
                                echo "No results found for query: '$query' in the selected directories.";
                                echo "</div>";
                            } else {
                                echo "<div class='alert alert-info' role='alert'>";
                                echo "<h4>Search results for: '$query'</h4><br>";
                                foreach ($search_results as $file => $lines) {
                                    echo "<p class='display_err'>Found '$query' in file '{$file}' <br> at line(s): " . implode(', ', $lines) . "</p><br>";
                                }
                                echo "</div>";
                            }
                        } ?>
                        <div class="text-center mt-3">
                            <a href="search_all.php" class="btn btn-secondary">Back to Search</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php 
}
?>
