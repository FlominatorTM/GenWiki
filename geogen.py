#based on https://dvenkatsagar.github.io/tutorials/python/2015/10/26/ddlv/

# The standard library modules
import os
import sys
import time
import argparse

# The selenium module
from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.by import By
from selenium.webdriver.firefox.options import Options

parser = argparse.ArgumentParser(description='Downloads surname maps from legacy.stoepel.net')
parser.add_argument('--surname', required=True, help="name to download images for")
parser.add_argument('--destination', required=False, default=os.getcwd(), help="path to save images to, defaults to current directory")
args = parser.parse_args()

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
op.set_preference("browser.download.dir",args.destination)
#MIME set to save file to disk without asking file type to used to open file
op.set_preference("browser.helperApps.neverAsk.saveToDisk","image/png")

#make sure you have geckodriver from https://github.com/mozilla/geckodriver/releases in PATH
driver = webdriver.Firefox(options=op) # if you want to use chrome, replace Firefox() with Chrome()
driver.get("https://legacy.stoepel.net/de?name=" + args.surname) # load the web page
WebDriverWait(driver, 50).until(EC.visibility_of_element_located((By.ID, "svgStatePie"))) # waits till the element with the specific id appears
#trigger download of images
driver.execute_script("saveMap('svgMapRelative', 'relativ')");
driver.execute_script("saveMap('svgMapAbsolute', 'absolut')");
#wait for images to be downloaded
time.sleep(3)
driver.close() # closes the driver
