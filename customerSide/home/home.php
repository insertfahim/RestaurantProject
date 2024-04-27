<?php
require_once '../config.php';


$sqlmainDishes = "SELECT * FROM Menu WHERE item_category = 'Main Dishes' ORDER BY item_type; ";
$resultmainDishes = mysqli_query($link, $sqlmainDishes);
$mainDishes = mysqli_fetch_all($resultmainDishes, MYSQLI_ASSOC);

$sqldrinks = "SELECT * FROM Menu WHERE item_category = 'Drinks' ORDER BY item_type; ";
$resultdrinks = mysqli_query($link, $sqldrinks);
$drinks = mysqli_fetch_all($resultdrinks, MYSQLI_ASSOC);

$sqlsides = "SELECT * FROM Menu WHERE item_category = 'Side Snacks' ORDER BY item_type; ";
$resultsides = mysqli_query($link, $sqlsides);
$sides = mysqli_fetch_all($resultsides, MYSQLI_ASSOC);




if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    echo '<div class="user-profile">';
    echo 'Welcome, ' . $_SESSION["member_name"] . '!';
    echo '<a href="../customerProfile/profile.php">Profile</a>';
    echo '</div>';
    
}

session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <title>Home</title>
</head>

<body>
 
 
<section id="header">
  <div class="header container">
    <div class="nav-bar">
      <div class="brand">
          <a class="nav-link" href="../home/home.php#hero">
            <h1 class="text-center" style="font-family:Copperplate; color:whitesmoke;"> FAHIM'S</h1><span class="sr-only"></span>
          </a>
      </div>
      <div class="nav-list">
        <div class="hamburger">
          <div class="bar"></div>
        </div>
          <div class="navbar-container">
            
              <div class="navbar">
        <ul>
          <li><a href="#hero" data-after="Home">Home</a></li>
          
          <li><a href="#projects" data-after="Projects">Menu</a></li>
          <li><a href="#about" data-after="About">About</a></li>
          <li><a href="#contact" data-after="Contact">Contact</a></li>
          <li><a href="../CustomerReservation/reservePage.php" data-after="Service">Reservation</a></li>
          <li><a href="../../adminSide/StaffLogin/login.php" data-after="Staff">Staff</a></li>
          
          
   

        <div class="dropdown">
            <button class="dropbtn">ACCOUNT <i class="fa fa-caret-down" aria-hidden="true"></i> </button>
        <div class="dropdown-content">
        
  <?php


$account_id = $_SESSION['account_id'] ?? null; 




if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $account_id != null) {
    $query = "SELECT member_name, points FROM memberships WHERE account_id = $account_id";


$result = mysqli_query($link, $query);
    
    if ($result) {
        
        $row = mysqli_fetch_assoc($result);
        
        if ($row) {
            $member_name = $row['member_name'];
            $points = $row['points'];
            
            
            $vip_status = ($points >= 1000) ? 'VIP' : 'Regular';
            
            
            $vip_tooltip = ($vip_status === 'Regular') ? ($points < 1000 ? (1000 - $points) . ' points to VIP ' : 'You are eligible for VIP') : '';
            
            
            echo "<p class='logout-link' style='font-size:1.3em; margin-left:15px; padding:5px; color:white; '>$member_name</p>";
            echo "<p class='logout-link' style='font-size:1.3em; margin-left:15px;padding:5px;color:white; '>$points Points </p>";
            echo "<p class='logout-link' style='font-size:1.3em; margin-left:15px;padding:5px; color:white; '>$vip_status";
            
            
            if ($vip_status === 'Regular') {
                echo " <span class='tooltip'>$vip_tooltip</span>";
            }
            
            echo "</p>";
        } else {
            echo "Member not found.";
        }
    } else {
        echo "Error: " . mysqli_error($link);
    }

    echo '<a class="logout-link" style="color: white; font-size:1.3em;" href="../customerLogin/logout.php">Logout</a>';
} else {
    
    echo '<a class="signin-link" style="color: white; font-size:15px;" href="../customerLogin/register.php">Sign Up </a> ';
    echo '<a class="login-link" style="color: white; font-size:15px; " href="../customerLogin/login.php">Log In</a>';
}


mysqli_close($link);
?>

     
    </div>
  </div> 
        </ul>
          </div>
          </div>
      </div>
    </div>
  </div>
</section>






<section id="hero" style="position: relative;">
    <img src="../image/ibrahim-boran-m8YjB0noWiY-unsplash.jpg" alt="restaurant background" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
    <div class="hero container" style="position: relative; z-index: 1;">
        <div>
            <h1><strong><h1 class="text-center" style="font-family:Copperplate; color:whitesmoke;"> FAHIM'S</h1><span></span></strong></h1>
            <h1><strong style="color:white;">DINING & MORE<span></span></strong></h1>
            <a href="#projects" type="button" class="cta">MENU</a>
        </div>
    </div>
</section>

  
  
  
  
  <section id="projects">
    <div class="projects container">
      <div class="projects-header">
        <h1 class="section-title"   >Me<span>n</span>u</h1>
      </div>
     
        
       <select style="text-align:center;" id="menu-category" class="menu-category">
        <option  value="blue">ALL ITEMS</option>
        <option value="yellow">MAIN DISHES</option>
        <option value="red">SIDE DISHES</option>
        <option value="green">DRINKS</option>
      </select>
        
    <div class="yellow msg"> 
     
        <div></div>
      <div class="mainDish">
           <h1 style="text-align:center;">MAIN DISHES</h1>
          <?php foreach ($mainDishes as $item): ?>
      <p>
        <span class="item-name"> <strong><?php echo $item['item_name']; ?></strong></span>
        <span class="item-price">BDT<?php echo $item['item_price']; ?></span><br>
        <span class="item_type"><i><?php echo $item['item_type']; ?></i></span>
        <hr>
        
      </p>
    <?php endforeach; ?>
      </div>
    </div>
      
      
    <div class="red msg">
        <div></div>
      <div class="sideDish">
           <h1 style="text-align:center">SIDE DISHES</h1>
          <?php foreach ($sides as $item): ?>
      <p>
        <span class="item-name"> <strong><?php echo $item['item_name']; ?></strong></span>
        <span class="item-price">BDT<?php echo $item['item_price']; ?></span><br>
        <span class="item_type"><i><?php echo $item['item_type']; ?></i></span>
        <hr>
      </p>
    <?php endforeach; ?>
      </div>
    </div>
        
      
      
    <div class="green msg">
        <div></div>
      <div class="drinks">
           <h1 style="text-align:center">DRINKS</h1>
          <?php foreach ($drinks as $item): ?>
      <p>
        <span class="item-name"> <strong><?php echo $item['item_name']; ?></strong></span>
        <span class="item-price">BDT<?php echo $item['item_price']; ?></span><br>
        <span class="item_type"><i><?php echo $item['item_type']; ?></i></span>
        <hr>
      </p>
    <?php endforeach; ?>
      </div>
    </div>
      
      
       <div class="blue msg">
          
      <div class="mainDish">
           <h1 style="text-align:center">MAIN DISHES</h1>
          <?php foreach ($mainDishes as $item): ?>
      <p>
        <span class="item-name"> <strong><?php echo $item['item_name']; ?></strong></span>
        <span class="item-price">BDT<?php echo $item['item_price']; ?></span><br>
        <span class="item_type"><i><?php echo $item['item_type']; ?></i></span>
        <hr>
      </p>
    <?php endforeach; ?>
      </div>
             
           
     
      <div class="sideDish">
           <h1 style="text-align:center">SIDE DISHES</h1>
          <?php foreach ($sides as $item): ?>
      <p>
        <span class="item-name"> <strong><?php echo $item['item_name']; ?></strong></span>
        <span class="item-price">BDT<?php echo $item['item_price']; ?></span><br>
        <span class="item_type"><i><?php echo $item['item_type']; ?></i></span>
        <hr>
      </p>
    <?php endforeach; ?>
      </div>
            
      
      <div class="drinks">
           <h1 style="text-align:center">DRINKS</h1>
          <?php foreach ($drinks as $item): ?>
      <p>
        <span class="item-name"> <strong><?php echo $item['item_name']; ?></strong></span>
        <span class="item-price">BDT<?php echo $item['item_price']; ?></span><br>
        <span class="item_type"><i><?php echo $item['item_type']; ?></i></span>
        <hr>
      </p>
    <?php endforeach; ?>
      </div>
          
      </div>
    </div>
  </section>
  
<section id="about" ">
  <div class="about container">
    <div class="col-right">
        <h1 class="section-title" >About <span>Us</span></h1>
        <h2>Fahim's DINING & MORE Company History:</h2>
 <p>Fahim's Dining & More is a well-established Western food establishment in the city's heart. Fahim's Dining & More has become a popular choice for customers looking to celebrate special occasions or simply enjoy a relaxing meal, with a focus on providing delicious meals and a friendly dining experience.
 </p>
 <p>Fahim's Dining & More, as a Western restaurant, offers a diverse menu that caters to a variety of tastes. The menu includes a wide range of options such as salads, soups and a variety of main courses. Customers can savour succulent options such as steak and ribs, chicken, lamb, seafood, burgers and sandwiches, pasta, and a variety of delectable side dishes. The menu has been carefully curated to offer a balance of classic favourites and innovative creations, ensuring that every palate is satisfied.
 </p>
 <p>Fahim's Dining & More's ability to accommodate customers is one of its distinguishing features. Fahim's Dining & More strives to create an inviting and comfortable dining environment, whether guests prefer to walk in or make reservations in advance. The restaurant recognises the significance of creating memorable experiences, particularly for those celebrating special occasions. Fahim's Dining & More is a popular choice for families, couples, and groups of friends because of its attentive staff and welcoming atmosphere.
 </p>
 <p>Fahim's Dining & More has an inviting outdoor area that is open seven days a week from 11:00 AM to 10:00 PM in addition to the indoor dining area.This outdoor space provides a relaxed setting for patrons to unwind and socialise while sipping on their favourite drinks and nibbling on bites.
 </p>
    
      </div>
    </div>
  </section>
  
<section id="contact" ">
  <div class="contact container">
    <div>
      <h1 class="section-title">Contact <span>info</span></h1>
    </div>
    <div class="contact-items">
      <div class="contact-item contact-item-bg">
        <div class="contact-info">
          <div class='icon'><img src="../image/icons8-phone-100.png" alt=""/></div>
          <h1>Phone</h1>
          <h2>+880 193 490 8343</h2>
        </div>
      </div>
      
      <div class="contact-item contact-item-bg"> 
        <div class="contact-info">
          <div class='icon'><img src="../image/icons8-email-100.png" alt=""/></div>
          <h1>Email</h1>
          <h2>faahim06@gmail.com</h2> 
        </div>
      </div>
      
      <div class="contact-item contact-item-bg">
        <div class="contact-info">
          <div class='icon'> <img src="../image/icons8-home-address-100.png" alt=""/></div>
          <h1>Address</h1>
          <h2>H#12,Road : 4, Block : L, Baridhara,Dhaka-1212 </h2>
        </div>
      </div>
    </div>
  </div>
</section>

  <section id="footer">
    <div class="footer container">
        <div class="brand">
          <h1>Drinks on the House</h1>
      </div>
        <h2>Follow our Socials</h2>
      <div class="social-icon">
        <div class="social-item">
          <a href="https://www.facebook.com"><img src="https://img.icons8.com/color/48/facebook.png" alt="facebook"/></a>
        </div>
        <div class="social-item">
          <a href="https://www.instagram.com"><img src="https://img.icons8.com/color/48/instagram-new.png" alt="instagram-new"/></a>
        </div>
          <div class="social-item">
          <a href="https://www.pinterest.com"><img src="https://img.icons8.com/color/48/pinterest.png" alt="pinterest-new"/></a>
        </div>
          <div class="social-item">
          <a href="https://www.tiktok.com"><img src="https://img.icons8.com/color/48/tiktok.png" alt="tiktok-new"/></a>
        </div>
          <div class="social-item">
          <a href="https://www.youtube.com"><img src="https://img.icons8.com/color/48/youtube-play.png" alt="youtube-new"/></a>
        </div>
          
        
      </div>
      <p>© 2024 Fahim's Dining & More</p>
      
      
    </div>
  </section>
  
  <script src="../js/app.js"></script>
   <style type="text/css">
       
       .navbar-container {
  width: 100%;
  padding: 0;
  margin: 0;
}
      .msg {
        font-family: 'Montserrat', sans-serif;
        margin-top: 25px;
        padding: 25px;
        display: none;
        color: black;
      }
      .yellow {
        background: #fff;
      }
      .green {
        background: #fff;
      }
      .red {
        background: #fff;
      }

      
   .menu-category {
  font-size: 24px;
  padding: 10px;
  border: 2px solid black; 
  outline: none;
  cursor: pointer;
  transition: border-color 0.3s ease, background-color 0.3s ease, color 0.3s ease;
  color: #000; 
  background-color: #fff; 
  border-radius: 0; 
}


.menu-category option {
  font-size: 20px;
}


.menu-category:hover {
  background-color: black; 
  color: white; 
}

      
      .msg {
        display: grid;
        grid-template-columns: repeat(3, 1fr); 
        grid-gap: 24px; 
      }

      
      .msg p {
        margin: 5px 0;
      }
      
    .item-name {
  display: inline-block; 
  width: 100%; 
  float: left;
}

.item-price {
  display: inline-block; 
  width: 30%; 
  float: right;
}

.user-profile {
    display: flex;
    align-items: center;
    color: white;
    margin-right: 20px;
}

.user-profile a {
    margin-left: 10px;
    color: white;
    text-decoration: none;
}


.profile-link {
  border: 1px solid #fff; 
  padding: 3px 8px; 
  border-radius: 3px; 
  text-decoration: none; 
  color: #fff; 
  margin-left: auto; 
  margin-right: 10px; 
}


#contact .col-right h2 {
  font-size: 24px; 
  color: white; 
}

#contact .col-right p {
  font-size: 18px; 
  color: white; 
}


.contact-item-bg {
  background-color: rgba(0, 0, 0, 0.7); 
  padding: 20px;
  border-radius: 5px;
  margin-bottom: 20px; 
}

.contact-item-bg h1,
.contact-item-bg h2 {
  color: white; 
}

.contact-item-bg i {
  color: #fff; 
}

.contact-item-bg .icon img {
  width: 80px; 
  height: 80px; 
}



.navbar {
  overflow: hidden;
  
}

.navbar a {
  float: left;
  font-size: 16px;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.dropdown {
  float: right;
  overflow: hidden;
}

.dropdown .dropbtn {
  font-size: 17px;  
  border: none;
  outline: none;
  color: white;
  padding: 13.9px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
  margin-top: 6px;
}

 .dropdown:hover .dropbtn {
  color: crimson;
  
}

.dropdown-content {
  display: none;
  position: absolute;
    background-color: rgba(0, 0, 0, 0.5);
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
  color: black;
}

.dropdown-content a {
  float: none;
  color: white;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {
  background-color: #ddd;
}

.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}


.dropdown-content a:hover {
  background-color: #ddd;
  color: black; 
}

.dropdown:hover .dropdown-content {
  display: block;
}

 .tooltip {
    display: none;
    position: absolute;
    background-color: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 5px;
    border-radius: 3px;
    font-size: 0.9em;
    margin-top: 50px; 
    left: 0; 
    width: 100%; 
    text-align: center; 
  }

    </style>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        $("select").change(function(){
            $(this).find("option:selected").each(function(){
                var val = $(this).attr("value");
                if(val){
                    $(".msg").not("." + val).hide();
                    $("." + val).show();
                } else{
                    $(".msg").hide();
                }
            });
        }).change();
    });
    
    
    
    
    
    

  $(document).ready(function(){
    
    function filterMenuItems(searchTerm) {
      $(".item-name").each(function() {
        var itemName = $(this).text().toLowerCase();
        if (itemName.includes(searchTerm)) {
          $(this).closest(".msg").show();
        } else {
          $(this).closest(".msg").hide();
        }
      });
    }
    
    
    $("#search-button").click(function() {
      var searchTerm = $("#search-input").val().toLowerCase();
      filterMenuItems(searchTerm);
    });
    
    
    $("#search-input").keyup(function() {
      var searchTerm = $(this).val().toLowerCase();
      filterMenuItems(searchTerm);
    });
  });

$(document).ready(function() {
    $('.dropdown-toggle').dropdown();
});

    </script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
    $('.logout-link').hover(function () {
      var $tooltip = $(this).find('.tooltip');
      var elementHeight = $(this).height();
      $tooltip.css('top', elementHeight + 10 + 'px'); 
      $tooltip.css('display', 'block');
    }, function () {
      $(this).find('.tooltip').css('display', 'none');
    });
  });
</script>


</body>

</html>

