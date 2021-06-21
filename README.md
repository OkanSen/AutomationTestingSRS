# AutomationTestingSRS
The project is named Project1 and contains 5 php files that contain the Php, Javascript and Html 
code for the individual pages that will be loaded. The only exception, is the server.php file 
that contains only Php code and is included by the registration and login php files for server 
to client and database communication. 

The project contains a python file named automated_test.py which contains the selenium test code 
and use the two .txt files present in the folder as inputs for the login and registration page 
during the testing process. 

The Project uses a database so it is recommended that a server/database application like xampp 
should be installed in the C: Drive and the project should be included in the htdocs folder of 
the xampp folder for the php files to run. Each individual php file can be opened in the browser, 
thereafter, via typing http://localhost/project1/login.php in the browser. 

It is important that a Chrome webdrive be installed and the directory of the webdriver be adjusted 
in the python code for the test automation to run. For example , 
“driver = webdriver.Chrome(r"C:\Users\Hassam\Desktop\chromedriver.exe", options=options)”, 
if the webdriver is directly located on the desktop. Furthermore, the driver.get() should have the 
location of the file it needs to get, it will be set to http://localhost/project1/xxx.php where xxx 
is the name of the php file by default, which is not an issue if the above steps were followed properly 
and the folder was located inside the htdocs folder. 

GitHub Page: https://github.com/OkanSen/AutomationTestingSRS
