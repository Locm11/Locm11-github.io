<?php
session_start();
include('../server/connection.php');
?>

<?php
include('../assets/includes/check_logged_in_admin.php');

// Show all categories
if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
    // if the user has already entered the page, then the page number is the selected one
    $page_no = $_GET['page_no'];
} else {
    // default page when the user enters categories.php
    $page_no = 1;
}

$stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM product_category");
$stmt1->execute();
$stmt1->bind_result($total_records);
$stmt1->store_result();
$stmt1->fetch();

// Categories per page
$total_records_per_page = 16;

$offset = ($page_no - 1) * $total_records_per_page;

$previous_page = $page_no - 1;
$next_page = $page_no + 1;

$adjacents = "2";

$total_no_of_pages = ceil($total_records / $total_records_per_page);

// get all categories

$stmt2 = $conn->prepare("SELECT * FROM product_category LIMIT $offset,$total_records_per_page");
$stmt2->execute();
$categories = $stmt2->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategoriju dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin_style.css">
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <?php include '../assets/includes/sidemenu.php'; ?>
            </div>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Informācijas Panelis</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                        </div>
                    </div>
                </div>

                <h2>Kategorijas</h2>

                <?php if (isset($_GET['category_updated'])) { ?>
                    <div class="success-message"><?php echo htmlspecialchars($_GET['category_updated']) ?></div>
                <?php } ?>

                <?php if (isset($_GET['category_failed'])) { ?>
                    <div class="error-message"><?php echo htmlspecialchars($_GET['category_failed']) ?></div>
                <?php } ?>

                <?php if (isset($_GET['deleted_successfully'])) { ?>
                    <div class="success-message"><?php echo htmlspecialchars($_GET['deleted_successfully']) ?></div>
                <?php } ?>

                <?php if (isset($_GET['deleted_failed'])) { ?>
                    <div class="error-message"><?php echo htmlspecialchars($_GET['deleted_failed']) ?></div>
                <?php } ?>

                <div class="table-responsive">
                    <table class="table  table-striped table-hover table-sm ms-auto">
                        <thead>
                            <tr>
                                <th scope="col">Category Id</th>
                                <th scope="col">Kategorijas nosaukums</th>
                                <th scope="col">Dzēst</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category) { ?>
                                <tr>
                                    <td><?php echo $category['category_id']; ?></td>
                                    <td><?php echo $category['category_name']; ?></td>
                                    <td><a class="btn btn-danger" href="delete_category.php?category_id=<?php echo $category['category_id']; ?>">Dzēst</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <nav aria-label="Page navigation example">
          <ul class="pagination mt-5">

            <li class="page-item <?php if($page_no<=1) {echo 'disabled';} ?>">
                <a class="page-link" href="<?php if($page_no <=1) {echo '#';}else{ echo "?page_no=".($page_no-1);}?>">Previous</a>
            </li>


            <li class="page-item"><a class="page-link" href="?page_no=1">1</a></li>
            <li class="page-item"><a class="page-link" href="?page_no=2">2</a></li>

            <?php if( $page_no >=3){ ?>
                <li class="page-item"><a class="page-link" href="#">...</a></li>
                <li class="page-item"><a class="page-link" href="<?php echo "?page_no=".$page_no; ?>"><?php echo $page_no; ?></a></li>
            <?php } ?>
 
            <li class="page-item <?php if($page_no>= $total_no_of_pages) {echo 'disabled';}?>">
                <a class="page-link" href="<?php if($page_no >= $total_no_of_pages){echo '#';} else { echo "?page_no=".($page_no+1);} ?>">Next</a>
            </li>
            </ul>
          </nav>
        </div>
      </main>
    </div>
  </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>