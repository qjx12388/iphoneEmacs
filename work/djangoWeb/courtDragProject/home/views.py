#!/usr/bin/env python
# -*- coding: utf-8 -*- 
from django.shortcuts import render
import sys
import logging
import urllib2
import urllib
import types
from pyquery import PyQuery as pq
from django.http import HttpResponse
from django.template import Context,loader

#from home.utils import MyHTMLParser

#from django.http import HttpResponse

# Create your views here.
# 使得 sys.getdefaultencoding() 的值为 'utf-8'  
reload(sys)                      # reload 才能调用 setdefaultencoding 方法  
sys.setdefaultencoding('utf-8')  # 设置 'utf-8'

domainName = "http://www.court.gov.cn/extension/search.htm?";
dictKV = {}#文件id 和 名字
requestUrls = []

def index(request):
    return render(request,'home/index.html')

def search(request):
    if request.method =='GET':
        strKeyWord = request.GET.get("keyWord")
        strCaseCode = request.GET.get("caseCode")
        strWenshuanyou = request.GET.get("wenshuanyou")
        strAnjianleixing = request.GET.get("anjianleixing")
        strDocSourceName = request.GET.get("docsourcename")
        strCourt = request.GET.get("court")
        strBeginDate = request.GET.get("beginDate")
        strEndDate = request.GET.get("endDate")
        strPage = request.GET.get("page")
        logging.debug(strPage)
        #debug infomation
        logging.debug("strKeyWord is %s" % strKeyWord)
        logging.debug("strCaseCode is %s" % strCaseCode)
        logging.debug("strWenshuanyou is %s" % strWenshuanyou)
        logging.debug("strAnjianleixing is %s" % strAnjianleixing)
        logging.debug("strDocSourceName is %s" % strDocSourceName)
        logging.debug("strCourt is %s" % strCourt)
        logging.debug("strBeginDate is %s" % strBeginDate)
        logging.debug("strEndDate is %s" % strEndDate)
        logging.debug("strPage is %s" % strPage)

#        logging.debug("domain name is %s" % domainName)
        strReq = domainName
#        if strKeyWord!=None and strKeyWord!="":
        strReq = "%skeyword=%s"%(strReq,strKeyWord)
        logging.debug(strKeyWord)
#        elif strCaseCode!=None and strCaseCode!="":
        strReq = "%s&caseCode=%s"%(strReq,strCaseCode)
#        elif strWenshuanyou!=None and strWenshuanyou!="":
        strReq = "%s&wenshuanyou=%s"%(strReq,strWenshuanyou)
#        elif strAnjianleixing!=None and strAnjianleixing!="":
        strReq = "%s&anjianleixing=%s"%(strReq,strAnjianleixing)
#        elif strDocSourceName !=None and strDocSourceName!="":
        strReq = "%s&docsourcename=%s"%(strReq,strDocSourceName)
#        elif strCourt!=None and strCourt!="":
        strReq = "%s&court=%s"%(strReq,strCourt)
#        elif strBeginDate!=None and strBeginDate!="":
        strReq = "%s&beginDate=%s"%(strReq,strBeginDate)
#        elif strEndDate!=None and strEndDate!="":
        strReq = "%s&endDate=%s"%(strReq,strEndDate)
#        elif strPage!=None and strPage!="":
#        index = strReq.find("&page")
#        logging.debug(strPage)
#        logging.debug(index)
#        if strReq.find("&page"):
#            index = strReq.find("&page")
#            strReq = strReq[0:index]
        if strPage!=None:
            strReq = "%s&adv=1&orderby=&order=&page=%s"%(strReq,strPage)
        
                            
        
#        domainName+"keyword="+strKeyWord+"&caseCode"+strCaseCode+"&wenshuanyou"+strWenshuanyou+"&anjianleixing"+strAnjianleixing+"&docsourcename="+strDocSourceName+"&court="+strCourt+"&beginDate="+strBeginDate+"&endDate="+strEndDate
#        strReq = urllib.urlencode(strReq)
        req = urllib2.Request(strReq)
        logging.debug("returnUrl %s" % strReq)        
        try:
            response = urllib2.urlopen(req,timeout=30)
            the_page = response.read()
            #file_object = open('/Users/corrin/Desktop/test.txt')
            #content = file_object.read()
            content = the_page

            # myParser = MyHTMLParser()
            # myParser.feed(content)
            # filterStr = myParser.getValue

            #.getTableBodyAndPage(content,"//table[@class='tablestyle']")

            pqDoc = pq(content)
            tbodyDoc = pqDoc('table .tablestyle')
            nextTable = tbodyDoc.next().outerHtml()

            trs = tbodyDoc('tr:gt(0)')
#            logging.debug("trs type is %s"%type(trs))
            trsFinal = ''
            dictKV.clear() #先清空,用于全部下载
            for tr in trs:
                requestUrl = pq(tr)('a').attr['href']
#               
                start = requestUrl.index('_')+1
                end = requestUrl.rindex('.')
                key = requestUrl[start:end]
                value = pq(tr)('a').attr('title')

                dictKV[key] = value
#                requestUrl = "http://www.court.gov.cn/downloadPdf/Download?docId=%s"%requestUrl[start:end]
                requestUrl = "/home/download/%s"%urllib.urlencode({key:value})

                requestUrls.append(requestUrl)
#                strContent = str("%s%s"%("<td><input type='checkbox' /></td>",pq(tr).html()))
                strContent = str("%s"%pq(tr).html())
                trsFinal += "<tr>%s<td align='center'><a href = '%s'>下载</a></td></tr>"%(strContent,requestUrl)
#                logging.debug("return %s" % pq(tr).html())
            #下一个table的 html 内容
            trsFinal+=nextTable
            context = {'htmlContent':trsFinal}
            return render(request,'home/result.html',context)
            #return render(request,'home/result.html',Context({'htmlContent':trsFinal}))
            

        except Exception as ex:
            print ex
            return render(request,'home/timeout.html')
#            print e.read()
#单个pdf文件下载
def download(request,param):
    try:
        fixedUrl = "http://www.court.gov.cn/downloadPdf/Download?docId="
        paramArray = param.split('=')
        url = "%s%s"%(fixedUrl,paramArray[0])
        filePathName = "%s.pdf"%paramArray[1]
        urllib.urlretrieve(url,filePathName)
        return HttpResponse("<script>alert('%s文件已下载');history.go(-1);</script>"%filePathName)
    except:
        return HttpResponse("<script>alert('服务器出现错误，请重试！');history.go(-1);</script>")

#批量下载pdf文件
def batchDownload(request):
    fixedUrl = "http://www.court.gov.cn/downloadPdf/Download?docId="
    try:
        logging.debug(dictKV)
        if dictKV != None and len(dictKV) >0 :
            for key,value in dictKV.items():
                url = "%s%s"%(fixedUrl,key)
                filePathName = "%s.pdf"%value
                urllib.urlretrieve(url,filePathName)
        return HttpResponse("<script type='text/javascript'>alert('全部文件已下载');</script>")
    except:
        return HttpResponse("<script>alert('下载过程中出现错误！');history.go(-1);</script>")


    

#    f = urllib2.urlopen(url)
#    data = f.read()
#    logging.debug(data)
#    with open ("a.pdf","wb") as code:
#        code.write(data)
#    return HttpResponse(None)
#    urllib.urlretrieve(url,"/aa.pdf")#"%s.pdf" % paramArray[1])


    

#    return HttpResponse("Hello,world!")
