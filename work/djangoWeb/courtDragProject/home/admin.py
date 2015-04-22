#!/usr/bin/python
# -*- coding: utf-8 -*-

from django.contrib import admin
from home.models import Category
import logging
from types import *
from django.forms import Select
from django.utils.encoding import force_unicode
from itertools import chain
from django.utils.html import escape, conditional_escape



try:
    # This was removed in Django 1.5+. We add it back to support Django 1.4.
    from django.utils.encoding import StrAndUnicode
    has_str_and_unicode = True
except ImportError:
    has_str_and_unicode = False
    from django.utils.encoding import python_2_unicode_compatible

    @python_2_unicode_compatible
    class StrAndUnicode(object):
        def __str__(self):
            return self.code


def fill_topic_tree(deep = 0, parent_id = 0, choices = []):
    if parent_id == 0:
        ts = Category.objects.filter(parent = None)
        choices[0] += (('', '---------'),)
        for t in ts:
            tmp = [()]
            fill_topic_tree(4, t.id, tmp)
            choices[0] += ((t.id, ' ' * deep + t.name,),)
            for tt in tmp[0]:
                choices[0] += (tt,)
    else:
        ts = Category.objects.filter(parent__id = parent_id)
        for t in ts:
            choices[0] += ((t.id,' ' * deep + t.name, ),)
            fill_topic_tree(deep + 4, t.id, choices)


        

class TreeSelect(Select):
    def __init__(self, attrs=None):
	super(Select, self).__init__(attrs)
		
    def render_option(self, selected_choices, option_value, option_label):
        # logging.debug(selected_choices)
        # logging.debug(option_label)
        # logging.debug(option_value)
        import ipdb
        ipdb.set_trace()
        option_value = force_unicode(option_value)
	if option_value in selected_choices:
            selected_html = u' selected="selected"'
            if not self.allow_multiple_selected:
                # Only allow for a single selection.
		selected_choices.remove(option_value)
            else:
		selected_html = ''
            return u'<option value="%s"%s>%s</option>' % (
                escape(option_value), selected_html,
		conditional_escape(force_unicode(option_label)).replace(' ', ' '))
			
    def render_options(self, choices, selected_choices):
	ch = [()]
	fill_topic_tree(choices = ch)
	self.choices = ch[0]
#        logging.debug(self.choices)
#	selected_choices = set(force_unicode(v) for v in selected_choices)
        selected_choices = set(force_unicode(v) for v in self.choices)
 	output = []
#        logging.debug(type(self.choices))
        # logging.debug(self.choices)
        # logging.debug(type(choices))
        # logging.debug(choices)
	for option_value, option_label in chain(self.choices, choices):
            # logging.debug(type(option_label))
            # logging.debug(option_label)
            # logging.debug(type(option_value))
            # logging.debug(option_value)

            if isinstance(option_label, (list, tuple)):
#            if isinstance(option_label, (str,unicode)):
                output.append(u'<optgroup label="%s">' % escape(force_unicode(option_value)).replace(' ', ' '))
		for option in option_label:
                    output.append(self.render_option(selected_choices, *option))
                output.append(u'</optgroup>')
            else:
                # logging.debug(option_label)
                # logging.debug(option_value)
                # logging.debug(output)
                # logging.debug(selected_choices)

                output.append(self.render_option(selected_choices, option_value, option_label))

        logging.debug(output)
        return u'\n'.join(output)

#from home.models import Pdf
#from home.models import treeNode
#from home.models import nodeRelation
#from django.contrib.sites.models import Pdf
#class SiteAdmin(admin.ModelAdmin):
#    search_field = ('keyWord','caseCode','wenshuanyou','anjianleixing','docsourcename','court','beginDate','endDate')
    
    
#admin.site.register(Pdf)
#admin.site.register(treeNode)
#admin.site.register(nodeRelation)

# Register your models here.

    # def fill_topic_tree(deep = 0, parent_id = 0, choices = []):
    #     if parent_id == 0:
    #         ts = Category.objects.filter(parent = None)
    #         choices[0] += (('', '---------'),)
    #         for t in ts:
    #             tmp = [()]
    #             fill_topic_tree(4, t.id, tmp)
    #             choices[0] += ((t.id, ' ' * deep + t.name,),)
    #             for tt in tmp[0]:
    #                 choices[0] += (tt,)
    #     else:
    #         ts = Category.objects.filter(parent__id = parent_id)
    #         for t in ts:
    #             choices[0] += ((t.id,' ' * deep + t.name, ),)
    #             fill_topic_tree(deep + 4, t.id, choices)






class CategoryAdmin(admin.ModelAdmin):
    fields = ['name','slug','parent']
    search_fields = ['name']
    list_display = ('name', 'slug')
#    prepopulated_fields = {"slug" : ("name",)}

    def formfield_for_dbfield(self, db_field, **kwargs):
        if db_field.name == 'parent':
            return db_field.formfield(widget = TreeSelect(attrs = {'width':120}))
        return super(CategoryAdmin, self).formfield_for_dbfield(db_field, **kwargs)
    

admin.site.register(Category, CategoryAdmin)
        
        
