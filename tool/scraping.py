# coding:utf-8
import urllib2
from bs4 import BeautifulSoup
import csv
import pprint

def getSlugByUrl(url):
  list = url.split("/")
  baseName = list[-1]
  baseName = baseName.replace('.html', '') # 拡張子をなくす
  return baseName

def getContents(targetClassName, url, targetIdName=None):
  # URLにアクセスする
  html = urllib2.urlopen(url)
  # htmlをBeautifulSoupで扱う
  soup = BeautifulSoup(html, "html.parser")
  targetContent = soup.find(class_=targetClassName);
  if(targetIdName) :
    targetContent = soup.find(id=targetIdName);
  
  return targetContent

def readOriginalContentsCSV(filePath):
  rows = []
  with open(filePath) as f:
    reader = csv.reader(f)
    for row in reader:
      rows.append(row)
  return rows

def getHeaderToIndexes(rows):
  headers = rows[0]
  headerToIndexes = {}
  indexNumber = 0
  for headName in headers:
    headerToIndexes[headName] = indexNumber
    indexNumber += 1
  return headerToIndexes

# def getTitleFromCSVData(row, headNameToIndexs):
#   return row[headNameToIndexs['Title']]

def createImportFileDataByCSVData(rows, headNameToIndexs):
  resultRows = []
  for row in rows[1:]:
    resultRow = {}
    resultRow['Slug'] = getSlugByUrl(row[headNameToIndexs['URL']])
    resultRow['Title'] = row[headNameToIndexs['Title']]
    resultRow['Content'] = getContents(None, url=row[headNameToIndexs['URL']], targetIdName="content")
    resultRows.append(resultRow)
  print resultRows
  return resultRows

def createFileByData(fileName, rows):
  with open(fileName, "w") as f: # 
    writer = csv.writer(f, lineterminator="\n") # writerオブジェクトの作成 改行記号で行を区切る
    for row in rows:
      record = []
      record.append(row['Slug'])
      record.append(row['Title'])
      record.append(row['Content'])
      writer.writerow(record) # csvファイルに書き込み