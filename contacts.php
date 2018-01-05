<?php

/* 
 *  Contacts Page v1.0
 *  Author	: Ihab Tag.
 *  Date	: 23/12/2017.
*/

session_start();
    
    if (isset($_SESSION['username'])) {
        require_once 'init.php';
        
        $do = isset($_GET['do']) ? $_GET['do'] : 'View';
        
        // Start View Contacts Page
        if ($do == 'View') {
            $statement = $con->prepare("SELECT * FROM contacts WHERE User_ID = ?");
            $statement->execute(array($_SESSION['id']));
            $rows = $statement->fetchAll();
?>
        
        <h2 class="text-center pageHead">Contacts</h2>
        
        <!-- Contacts Buttons -->
        <div class="membersNav text-left">
            <a class="btn btn-success" name="new" href="contacts.php?do=New" method="GET"><i class="fa fa-plus-square" aria-hidden="true"></i> New</a>
        </div>

        <!-- Contacts Main Table -->
        <table class="table table-responsive">
            <thead>
              <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Name</th>
                    <th scope="col">Group</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Email</th>
                    <th scope="col">Delete</th>
              </tr>
            </thead>
            <tbody>
<?php
        // Looping through the database table contacts to get the contacts details and view them on the main table
        $rowCounter = 1;    // The table row counter for the column [#]
        
        foreach ($rows as $row) { 
                
                echo '<tr class="clickableRow" data-href="contacts.php?do=Open&id=' . $row['ContactID'] . '">';
                    echo '<th scope="row">' . $rowCounter++ . '</th>';
                    echo '<td>' . $row['ContactName'] . '</td>';
                    echo '<td>' . $row['ContactGroup'] . '</td>';
                    echo '<td>' . $row['ContactPhone'] . '</td>';
                    echo '<td>' . $row['ContactEmail'] . '</td>';
                    echo '<td><a class="btn btn-danger" name="delete" href="contacts.php?do=Delete&id=' . $row['ContactID'] . '" method="GET"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>';
                echo '</tr>';
            
        }
        echo '</tbody></table>'; 


//        echo '<div class="membersNav text-left">';
//        echo    '<a class="btn btn-success" name="new" href="contacts.php?do=New" method="GET"><i class="fa fa-plus-square" aria-hidden="true"></i> New</a>';
//        echo '</div>';        // Closing the table tags
        
        // Start Open Contact Page
        }elseif ($do == 'Open') {
            
            $statement = $con->prepare('SELECT * FROM contacts WHERE ContactID = ?');
            $statement->execute(array($_GET['id']));
            $row = $statement->fetch();
            $selectedCotactID = $row['ContactID'];
            
?>      
        
        <h2 class="text-center pageHead">Contact Details</h2>
        
        <div class="membersNav text-center">
            <a class="btn btn-warning" name="edit" href="contacts.php?do=Edit&id=<?php echo $selectedCotactID; ?>" method="GET" id="editBtn"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>
            <a class="btn btn-danger" name="delete" href="contacts.php?do=Delete&id=<?php echo $selectedCotactID; ?>" method="GET"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a>
        </div>
       
        <form class="contactData" action="?do=Open" method="GET">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Name</label>
              <div class="col-sm-10">   
                  <label class="col-form-label contact-details"><?php echo $row['ContactName'] ?></label>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label ">Group</label>
              <div class="col-sm-10">
                    <label class="col-form-label contact-details "><?php echo $row['ContactGroup'] ?></label>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Phone</label>
              <div class="col-sm-10">
                <label class="col-form-label contact-details"><?php echo $row['ContactPhone'] ?></label>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                  <label class="col-form-label contact-details"><?php echo $row['ContactEmail'] ?></label>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Birth Date</label>
              <div class="col-sm-10">
                  <label class="col-form-label contact-details"><?php echo $row['ContactBD'] ?></label>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Facebook Profile</label>
              <div class="col-sm-10">
                  <label class="col-form-label contact-details"><a target="blank" href="<?php echo $row['ContactFB'] ?>"><?php echo $row['ContactFB'] ?></a></label>
              </div>
            </div>
        </form>   
        
        
<?php
        }elseif ($do == 'New') {
            
            $statement = $con->prepare('SELECT GroupName FROM groups WHERE UserID = ?');
            $statement->execute(array($_SESSION['id']));
            $groups = $statement->fetchAll();
?>      
        
        <h2 class="text-center pageHead">New Contact</h2>
        
        <form action="?do=Insert" method="POST">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Name</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" name="contactName" required="required" placeholder="Ful Name">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Group</label>
              <div class="col-sm-10">
                    <select class="form-control" name="contactGroup" required>
                        <option value="" >Select a Group</option>
                        <?php
                        foreach ($groups as $group) {
                        echo '<option value="' . $group[GroupName] . '">' . $group[GroupName] . '</option>';    
                        }
                        ?>
                    </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Phone</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="contactPhone" required="required" placeholder="Phone Number">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                  <input type="email" class="form-control" name="contactEmail" placeholder="Email">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Birth Date</label>
              <div class="col-sm-10">
                  <input type="date" class="form-control" name="contactBD">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Facebook Profile</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="contactFB" placeholder="Facebook Profile Link">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-10 col-sm-offset-2">
                <button type="submit" class="btn btn-primary full-width">Submit</button>
              </div>
            </div>

        </form>   
<?php

        // Start Insert Page
        }elseif ($do == 'Insert') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                echo '<h2 class="text-center pageHead">Insert</h2>';
                
                $name       = $_POST['contactName'];
                $group      = $_POST['contactGroup'];
                $phone      = $_POST['contactPhone'];
                $email      = $_POST['contactEmail'];
                $bD         = $_POST['contactBD'];
                $faceBook   = $_POST['contactFB'];
                $userID     = $_SESSION['id'];
                
                // Validating form input
                
                $formErrors = array();
                
                if (strlen($name) < 2) {$formErrors=['<div class="alert aler-danger">Name can\'t be less than 2 charachters</div>'];}
                if (empty($group)) {$formErrors=['<div class="alert aler-danger">You should choose a valid group</div>'];}
                if (strlen($phone) < 7) {$formErrors=['<div class="alert aler-danger">Phone can\'t be less than 7 charachters</div>'];}
                
                if (!empty($formErrors)){
                    foreach ($formErrors as $error){
                        echo $error;
                    }
                }else{
                    $statement = $con->prepare("INSERT INTO contacts(ContactName, ContactGroup, ContactPhone, ContactEmail, ContactBD, ContactFB, User_ID) VALUES (:zname, :zgroup, :zphone, :zemail, :zbd, :zfb, :zuser)");
                    $statement->execute(array('zname' => $name, 'zgroup' => $group, 'zphone' => $phone, 'zemail' => $email, 'zbd' => $bD, 'zfb' => $faceBook, 'zuser' => $userID));
                    echo '<div class="alert alert-success">' . $statement->rowCount() . ' contact was added successfully</div>';
                    redirection('contacts.php', 3, 'You will be redirected to contacts after 3 seconds');
                }
            }else{
                header('Location: index.php');
            }
            
        }elseif ($do == 'Edit') {
     
      
        $statement = $con->prepare('SELECT * FROM contacts WHERE ContactID = ?');
        $statement->execute(array($_GET['id']));
        $row = $statement->fetch();
        $selectedCotactID = $row['ContactID'];
        
?> 
        <h2 class="text-center pageHead">Edit</h2>

        <form action="?do=Update" method="POST">
              <label class="col-sm-2 col-form-label hideElement">ContactID</label>
              <input type="text" class="form-control hideElement" name="contactID" value="<?php echo $row['ContactID'] ?>">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Name</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" name="contactName" required="required" placeholder="Ful Name" value="<?php echo $row['ContactName'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Group</label>
              <div class="col-sm-10">
                    <select class="form-control" name="contactGroup" required>
                        <option value="" >Select a Group</option>
                        <?php
                        
                        $statement = $con->prepare('SELECT GroupName FROM groups WHERE UserID = ?');
                        $statement->execute(array($_SESSION['id']));
                        $groups = $statement->fetchAll();
                        
                        foreach ($groups as $group) {
                        echo '<option value="' . $group[GroupName] . '">' . $group[GroupName] . '</option>';    
                        }
                        ?>
                    </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Phone</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="contactPhone" required="required" placeholder="Phone Number"  value="<?php echo $row['ContactPhone'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                  <input type="email" class="form-control" name="contactEmail" placeholder="Email" value="<?php echo $row['ContactEmail'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Birth Date</label>
              <div class="col-sm-10">
                  <input type="date" class="form-control" name="contactBD" value="<?php echo $row['ContactBD'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Facebook Profile</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="contactFB" placeholder="Facebook Profile Link" value="<?php echo $row['ContactFB'] ?>">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-10 col-sm-offset-2">
                <button type="submit" class="btn btn-primary full-width">Submit</button>
              </div>
            </div>

        </form>   
        
<?php
        // Start Update Page
        }elseif ($do == 'Update') {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                echo '<h2 class="text-center pageHead">Update</h2>';
                
                $contactID  = $_POST['contactID'];
                $name       = $_POST['contactName'];
                $group      = $_POST['contactGroup'];
                $phone      = $_POST['contactPhone'];
                $email      = $_POST['contactEmail'];
                $bD         = $_POST['contactBD'];
                $faceBook   = $_POST['contactFB'];
                $userID     = $_SESSION['id'];
                
                // Validating form input
                
                $formErrors = array();
                
                if (strlen($name) < 2) {$formErrors=['<div class="alert aler-danger">Name can\'t be less than 2 charachters</div>'];}
                if (empty($group)) {$formErrors=['<div class="alert aler-danger">You should choose a valid group</div>'];}
                if (strlen($phone) < 7) {$formErrors=['<div class="alert aler-danger">Phone can\'t be less than 7 charachters</div>'];}
                
                if (!empty($formErrors)){
                    foreach ($formErrors as $error){
                        echo $error;
                    }
                }else{
                    $statement = $con->prepare("UPDATE contacts SET ContactName = ?, ContactGroup = ?, ContactPhone = ?, ContactEmail = ?, ContactBD = ?, ContactFB = ? WHERE ContactID = ?");
                    $statement->execute(array($name, $group, $phone, $email, $bD, $faceBook, $contactID));
                    echo '<div class="alert alert-success">' . $statement->rowCount() . ' contact was updated successfully</div>';
                    redirection('contacts.php', 3, 'You will be redirected to contacts page after 3 seconds');
                }
            }else{
                header('Location: index.php');
            }
            
        }elseif ($do == 'Delete') {
        
        echo '<h2 class="text-center pageHead">Delete Contact</h2>';
        
        $contactID = $_GET['id'];
        $statement = $con->prepare('DELETE FROM contacts WHERE ContactID = ?');
        $statement->execute(array($contactID));
        
        echo '<div class="alert alert-danger">1 contacts was successfully deleted</div>';
        redirection('contacts.php', 3, 'You will be redirected to contacts page after 3 seconds');
        
        }
        
        require_once $tmpl . 'footer.php';
    }else{
        header('Location: index.php');
        exit();
    }