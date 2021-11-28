#based on https://dvenkatsagar.github.io/tutorials/python/2015/10/26/ddlv/ 
# and on Python 3 server example

# The standard library modules
import os
import sys
import time
from os.path import exists

# The selenium module
from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.by import By
from selenium.webdriver.firefox.options import Options



from http.server import BaseHTTPRequestHandler, HTTPServer
import time

hostName = "localhost"
serverPort = 8080
cacheDir = os.sep + "cache"

class MyServer(BaseHTTPRequestHandler):
    def do_GET(self):
        
        ##/geogen/relativ/Straub.png
        requestParts = self.path.split("/")

        print(requestParts)
        surname = requestParts[len(requestParts)-1].replace(".png", "").upper()
        mode = requestParts[len(requestParts)-2]
        
        filepath = os.getcwd() + cacheDir + os.sep + surname + "-" + mode + ".png"
        print (filepath)
        if not exists(filepath):
            self.get_pictures(surname)
        
        self.send_response(200)
        self.send_header("Content-type", "image/png")
        self.end_headers()
        
        self.wfile.write(self.load_binary(filepath))

    def load_binary(self, filename):
        with open(filename, 'rb') as file_handle:
            return file_handle.read()

        
    def get_pictures(self, surname):
        #make Firefox save PNG image downloads without asking
        # via https://www.tutorialspoint.com/how-do-i-automatically-download-files-from-a-pop-up-dialog-using-selenium-python
        #object of Options class
        op = Options()
        #do not require a monitor (remove for debugging)
        op.add_argument("--headless")
        #save file to path defined for recent download with value 2
        op.set_preference("browser.download.folderList",2)
        #disable display Download Manager window with false value
        op.set_preference("browser.download.manager.showWhenStarting", False)
        #download location
        op.set_preference("browser.download.dir",  os.getcwd() + cacheDir)
        #MIME set to save file to disk without asking file type to used to open file
        op.set_preference("browser.helperApps.neverAsk.saveToDisk","image/png")

        #make sure you have geckodriver from https://github.com/mozilla/geckodriver/releases in PATH
        driver = webdriver.Firefox(options=op) # if you want to use chrome, replace Firefox() with Chrome()
        driver.get("https://legacy.stoepel.net/de?name=" + surname) # load the web page
        WebDriverWait(driver, 50).until(EC.visibility_of_element_located((By.ID, "svgStatePie"))) # waits till the element with the specific id appears
        #trigger download of images
        driver.execute_script("saveMap('svgMapRelative', 'relativ')");
        driver.execute_script("saveMap('svgMapAbsolute', 'absolut')");
        #wait for images to be downloaded
        time.sleep(3)
        driver.close() # closes the driver

if __name__ == "__main__":        

    webServer = HTTPServer((hostName, serverPort), MyServer)
   
    print("Server started http://%s:%s" % (hostName, serverPort))

    try:
        webServer.serve_forever()
    except KeyboardInterrupt:
        pass

    webServer.server_close()
    print("Server stopped.")





