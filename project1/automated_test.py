import selenium
import time
from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support import expected_conditions as EC 
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait


def enter_credentials(id, password):
    # Finds id and password text areas
    id_field = driver.find_element_by_id("id-field")
    pass_field = driver.find_element_by_id("password-field")

    #Clear the text fields
    id_field.clear()
    pass_field.clear()

    # Enters the given parameters into text fields
    id_field.send_keys(id)
    pass_field.send_keys(password)

    # Press submit
    #submit = driver.find_element_by_id("login-form-submit")
    #submit = driver.find_element_by_xpath("html/body/div/form/input[3]")
    submit = WebDriverWait(driver, 5).until(EC.element_to_be_clickable((By.ID, "login-form-submit")))
    submit.click()
    
# set the wait time between each action
t = 1

# Selenium setup for chrome using webdrivers
options = webdriver.ChromeOptions()

options.add_argument('--no-sandbox')
options.add_argument('--disable-dev-shm-usage')
options.add_argument("--mute-audio")


driver = webdriver.Chrome('C:\\webdrivers\\chromedriver.exe', options=options)
driver.maximize_window()

# ------------------------------------ REGISTER TEST ------------------------------------------------
# First test case will include registration tests as well so let's start from there
# and then add them up with login tests to finish up the first test case
# Last trial in this page will be a successful registration which can be seen from the database

# go to registration page
driver.get("http://localhost/project1/registration.php")

# Using readlines()
file1 = open('test cases register.txt', 'r')
lines1 = file1.readlines()

for line in lines1:

    #Split the line by white spaces to get two indexes of information
    # 0 index is email, 1 index is password
    credentials = line.split("\t")

    print("testing id: ", credentials[0],", password: ", credentials[1], credentials[2])
    email = credentials[0]
    password = credentials[1]
    password2 = credentials[2]

    email_field = driver.find_element_by_id("email-field")
    password_field = driver.find_element_by_id("password-field")
    re_password_field = driver.find_element_by_id("re-password-field")

    time.sleep(t)

    #Clear the text fields
    email_field.clear()
    password_field.clear()
    re_password_field.clear()

    # Enter info
    email_field.send_keys(email)
    password_field.send_keys(password)
    re_password_field.send_keys(password2)


    # Click sign up
    driver.find_element_by_id("registration-form-submit").click()

    # Wait for error to be read by user
    time.sleep(t)
# ------------------------------------------------------------------------------------------------
time.sleep(t)
# ------------------------------------ LOGIN TEST ------------------------------------------------
# Now go to login page
driver.get("http://localhost/project1/login.php")

# Using readlines()
file1 = open('test cases.txt', 'r')
lines = file1.readlines()

wrong_cases = 0
line_count = 0
for line in lines:
    #Split the line by white spaces to get two indexes of information
    # 0 index is id, 1 index is password
    credentials = line.split("\t")
    print("-----------------------------------------------------------")
    print()
    print("testing id: ", credentials[0],", password: ", credentials[1])
    print(line_count)

    # ------------------------------------ LOGIN TEST CASE 1 ------------------------------------------------
    if line_count < 8:
        # TEST CASE 1
        # wrong/correct credentials test case
        #
        # These cases are considered as only 1 case
        # multiple wrong credential entries such as; 
        # string in id, too long id, blank id/password
        # or wrong id password combination
        # lastly correct id and password results in successful login
        print("TEST CASE 1")
        print("testing invalid/wrong/correct id/password combinations for login and registration")
        print()

        # Call automated submission method
        enter_credentials(credentials[0], credentials[1])

        if line_count == 4:
            time.sleep(t*2)
            driver.switch_to.alert.accept()
        time.sleep(t)
        print()
    # -------------------------------------------------------------------------------------------------------
    # ------------------------------------ LOGIN TEST CASE 2 ------------------------------------------------
    elif line_count < 9:
        # TEST CASE 2
        # no multi sessions case
        #
        print("TEST CASE 2")
        print("testing new tab login page")
        print()

        # Open new tab
        driver.execute_script('''window.open("http://bings.com","_blank");''')

        # Switch tab
        driver.switch_to.window(driver.window_handles[1])

        # Go to login page
        time.sleep(t)
        driver.get("http://localhost/project1/login.php") # this page will automatically be directed to success.php
        time.sleep(t)

        # close current tab
        driver.close()

        # Switch tab
        driver.switch_to.window(driver.window_handles[0])
        time.sleep(t)
        print("testing pressing back button at success.php page")

        # Press back button. This will also result in redirection to Success.php since we have a session system.
        driver.execute_script("window.history.go(-1)") # results in success.php again bcz of sessions
        time.sleep(t)
        
        # The session also stays online even when the tab is 
        # closed and a new tab is opened and the user went to 
        # login page. The user will be redirected to success.php as expected.
        print("testing opening new empty tab, closing success page, then going to login page with the empty tab")

        # Open new tab
        driver.execute_script('''window.open("http://bings.com","_blank");''')
        time.sleep(t)

        # close first tab
        driver.switch_to.window(driver.window_handles[0])
        driver.close()
        time.sleep(t)

        # switch to new tab
        driver.switch_to.window(driver.window_handles[0])

        # go to login page 
        driver.get("http://localhost/project1/login.php") # this page will automatically be directed to success.php 
        time.sleep(t)
        time.sleep(t)
        # Logout from account
        print("logging out...")
        driver.find_element_by_id("return_to_login").click()
        print()
        time.sleep(t)

    # -------------------------------------------------------------------------------------------------------        
    # ------------------------------------ LOGIN TEST CASE 3 ------------------------------------------------
    elif line_count < 12:
        wrong_cases += 1
        # TEST CASE 3
        # 3 incorrect logins result in 5 seconds timeout
        #
        print("TEST CASE 3")
        print("testing 3 wrong id/password combinations timeout")
        print()
        time.sleep(t)
        
        # Call automated submission method
        enter_credentials(credentials[0], credentials[1])
        print("wrong entry #",wrong_cases)
        time.sleep(t)
        # Click ok alert
        driver.switch_to.alert.accept()
        time.sleep(t)
        
        if wrong_cases == 3:
            time.sleep(t)
            # Close the warning pop up
            driver.switch_to.alert.accept()

            # wait for timeout then close popup
            time.sleep(6)
            driver.switch_to.alert.accept()
            time.sleep(t)
    # -------------------------------------------------------------------------------------------------------
    # ------------------------------------ LOGIN TEST CASE 4 ------------------------------------------------
    elif line_count < 13:
        # TEST CASE 4
        # Enter key working as submit button
        #
        print("TEST CASE 4")
        print("testing enter key as submit button")
        print()

        
        time.sleep(t)


        id = credentials[0]
        password = credentials[1]

        # Finds id and password text areas
        id_field = driver.find_element_by_id("id-field")
        pass_field = driver.find_element_by_id("password-field")
        submit = driver.find_element_by_id("login-form-submit")

        #Clear the text fields
        id_field.clear()
        pass_field.clear()
        time.sleep(t)

        # Show that enter works by pressing enter without filling fields
        print("pressing enter with empty fields")
        submit.send_keys(u'\ue007')
        time.sleep(t)

        #Clear the text fields
        id_field.clear()
        pass_field.clear()

        # Enters the given parameters into text fields
        id_field.send_keys(id)
        pass_field.send_keys(password)
        time.sleep(t)

        print("pressing enter with correct entries")
        submit.send_keys(u'\ue007')
        time.sleep(t)
    # -------------------------------------------------------------------------------------------------------
    # ------------------------------------ LOGIN TEST CASE 5 ------------------------------------------------
    elif line_count  < 16:
        # TEST CASE 5
        # After 3 seconds of inactivity the user is actually logged out automatically
        # 3 seconds here can be changed from server.php, for the sake of quick testing it is set to 3
        #
        print("TEST CASE 5")
        print("testing logout after 3 seconds of inactivity") 
        print()

        # Wait for 5 seconds to be safe
        time.sleep(5)

        # Now reload the page
        print("refreshing after 5 seconds of inactivity")
        driver.refresh()
        time.sleep(t)

        # also go back
        driver.execute_script("window.history.go(-1)")
        time.sleep(t)
        time.sleep(t)

    # -------------------------------------------------------------------------------------------------------




    line_count += 1
