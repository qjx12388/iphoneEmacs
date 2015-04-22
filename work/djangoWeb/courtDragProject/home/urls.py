from django.conf.urls import patterns, include, url
#from django.contrib import admin
from home import views


urlpatterns = patterns('',
    # Examples:
    #url(r'^$', 'courtDragProject.views.home', name='home'),
#   url(r'^$', 'courtDragProject.home.views.index'),
    url(r'^search', views.search, name = 'search'),
    # url(r'^blog/', include('blog.urls')),
    url(r'^download/(.+)$',views.download,name = 'download'),
    url(r'batchDownload$',views.batchDownload,name='batchDownload'),
#    url(r'^admin/', include(admin.site.urls)),
#    url(r'^home/', include('home')),
#    url(r'^home/', include('home.urls', namespace="home)),
    
)
