<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Search Files</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">GLOBAL SEARCH</h3>
                    </div>
                    <div class="card-body">
                        <form action="search_results.php" method="post">
                            <div class="form-group">
                                <label for="query">Search :</label>
                                <input type="text" id="query" name="query" class="form-control" required placeholder="Enter text to search">
                            </div>
                            <div class="form-group">
                                <label>Search in:</label><br>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="all" name="directories[]" value="." checked>
                                    <label class="form-check-label" for="all">All</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="plugins" name="directories[]" value="plugins">
                                    <label class="form-check-label" for="plugins">Plugins</label>
                                </div>
                               
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="themes" name="directories[]" value="themes">
                                    <label class="form-check-label" for="themes">Themes</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="uploads" name="directories[]" value="uploads">
                                    <label class="form-check-label" for="uploads">Uploads</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="wp-admin" name="directories[]" value="wp-admin">
                                    <label class="form-check-label" for="wp-admin">Wp-admin</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="wp-content" name="directories[]" value="wp-content">
                                    <label class="form-check-label" for="wp-content">Wp-content</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="wp-includes" name="directories[]" value="wp-includes">
                                    <label class="form-check-label" for="wp-includes">Wp-includes</label>
                                </div>
                                
                                
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Search</button>
                        </form>
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
