# mainKAA/urls.py
from django.urls import path
from . import views

urlpatterns = [
    path('', views.select_document, name='home'),
    path('login/', views.login_view, name='login'),
    path('logout/', views.logout_view, name='logout'),
    path('profile/', views.profile_view, name='profile'),
    path('document/', views.document_form, name='document_form'),
    path('select/', views.select_document, name='select_document'),
]