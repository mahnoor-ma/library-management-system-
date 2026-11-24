 <!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Library Header</title>
    
    <style>
        .container1 {
            background-color: rgb(58, 58, 58);  
            display: flex;
     justify-content: center;
       margin:0px;
            
        } 

          .container1 ul a{
            color: white;  
            padding: 0.5rem 1rem; 
        }
       .container1 ul a:hover {
            color: #ccc ; 
        }.container2{
 
        } 
        nav ul li{
            display: inline;
list-style-type: none;
        }nav ul {
            margin-top:15px
        }

        /* Remove the problematic fixed positioning and custom styling from the original code */
        /* You can remove the old custom CSS below or comment it out */
        /*
        header {
            width: 100%;
            height: 50px;
            display: flex;
            justify-content: space-between;
            padding: 0 12%;
            position: fixed;
            top: 3px;
        }
        nav ul li{
            display: inline-block;
            padding:10px;
        }
        */
       .logo{
            width: 60px;
             padding: 10px;
        }
        
        .name {
            color:  white; 
            font-size: 1.5rem;
            font-weight: bold;
            margin-top: 10px;
               
        }.mainlogo{
            display: flex;
            margin-right: 700px;
            padding:10px ;
            
        }
    </style>
</head>
<body>
<header>
    <nav class="container1">
         <div class="mainlogo">
      <img class="logo" src="assets/img/lib.png" alt="Hero Background">
        <a class="name" href="index.php">LIBRARY</a>
         </div>
        <div >
            <ul>
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>
                    <a href="inserte-records.php">Add Books</a>
                </li>
                <li>
                    <a href="show-records.php">View Books</a>
                </li>
                <li>
                    <a href="login.php">Login</a>
                </li>
                <li> 
                    <a href="t.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
   </header>
</body>
</html>