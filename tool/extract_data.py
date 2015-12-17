import os
import sys
import shutil
import codecs

CRAWL_LOCATION = '..//crawl_data//'
EXTRACT_LOCATION = '..//extract_data//'

FJoin = os.path.join

def GetAllFile(path):
    file_list, dir_list = [], []
    for dir, subdirs, files in os.walk(path):
        file_list.extend([FJoin(dir, f) for f in files])
        dir_list.extend([FJoin(dir, d) for d in subdirs])
    return file_list, dir_list
	
###################################################################
files, dirs = GetAllFile(CRAWL_LOCATION)

f = open(files[0], 'r')
text = f.read()
f.close()

text_unicode = unicode(text, 'utf-8')
print text_unicode

fa = open(files[1], 'w')
fa.write(text[0:19])
fa.close()

#for(file in files):
	
