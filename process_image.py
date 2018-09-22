import numpy as np
from PIL import Image
from sys import argv
import os

img = Image.open("./upload/" + argv[1],'r')
img = img.convert('L') #makes it greyscale
imgcvt = np.asarray(img.getdata(),dtype=np.float64).reshape((img.size[1],img.size[0]))


imgcvt = np.asarray(imgcvt, dtype=np.uint8) #if values still in range 0-255!
output = Image.fromarray(imgcvt, mode='L')

if not os.path.exists("./output/"):
    os.makedirs("./output/")

output.save("./output/" + argv[1])
