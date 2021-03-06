from django.conf.urls import patterns, include, url
from django.contrib import admin
from home import views
from django.conf import settings

urlpatterns = patterns('',
    # Examples:
    #url(r'^$', 'courtDragProject.views.home', name='home'),
#   url(r'^$', 'courtDragProject.home.views.index'),
    url(r'^$', views.index, name = 'index'),
    # url(r'^blog/', include('blog.urls')),

    url(r'^admin/', include(admin.site.urls)),
#    url(r'^home/', include('home')),
    url(r'^home/', include('home.urls', namespace="home")),
    
)

if settings.DEBUG:
    import debug_toolbar
    urlpatterns += patterns('',
        url(r'^__debug__/', include(debug_toolbar.urls)),
    )
