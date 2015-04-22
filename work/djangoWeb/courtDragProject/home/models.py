# -*- coding: utf-8 -*- 
from django.db import models

#class Pdf(models.Model):
#    id = models.AutoField(primary_key = True) #主键
#    keyWord = models.CharField('关键字:',max_length = 100,help_text = '最多输入100个关键字') #关键字
#    caseCode = models.CharField('案  号:',max_length = 100,help_text = '最多输入100个关键字') #案号
#    wenshuanyou = models.CharField('案由:',max_length = 100,help_text = '最多输入100个关键字') #案由
#    anjianleixing = models.CharField('案件类型:',max_length = 20)
#    docsourcename = models.CharField('文书类型:', max_length =20)
#    court = models.CharField('审理法院',max_length = 100,help_text = '最多输入100个关键字') #审理法院
#    beginDate = models.DateField('裁判时间：从')
#    endDate = models.DateField('到')
       
#    def __str__(self):
#        return "%s, %s, %s, %s, %s, %s, %s, %s"%(self.keyWord,self.caseCode,self.wenshuanyou,self.anjianleixing,self.docsourcename,self.court,self.beginDate,self.endDate)

#    class Admin:
 #       list_display = ("关键字")#,"caseCode","wenshuanyou","anjianleixing","docsourcename","court","beginDate","endDate")
  #      search_field = ("关键字")


# Create your models here.

#创建关于树的两张表
#table 1
#class treeNode(models.Model):
#    nodeid = models.AutoField(primary_key = True) #主键
#    nodeValue = models.CharField('节点名:',max_length = 100,help_text = '最多输入50个字') #节点的名字

#    def __str__(self):
#        return "%s,%s"%(self.nodeid,self.nodeValue)

#class nodeRelation(models.Model):
#    ancestor = models.PositiveIntegerField('父节点:',help_text = '请输入正整数')
#    descendant = models.PositiveIntegerField('子节点:',help_text = '请输入正整数')
#    depth = models.PositiveIntegerField('节点深度:',help_text = '请输入正整数')

#    def __str__(self):
#        return "%d,%d"%(self.ancestor,self.descendant,self.depth)

#table 2

#table 自引用
class  Category(models.Model):
    name = models.CharField('级别名称：', max_length = 100, blank = False)
    slug = models.SlugField('简称：', db_index = True)
    parent = models.ForeignKey('self', null = True, blank = True)
        
    def __unicode__(self):
        return u'%s' % self.name


