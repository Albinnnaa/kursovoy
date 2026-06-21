# mainKAA/models.py
from django.db import models
from django.contrib.auth.models import User

class StudentProfile(models.Model):
    user = models.OneToOneField(User, on_delete=models.CASCADE)
    fio = models.CharField(max_length=200, verbose_name='ФИО', blank=True)
    grupa = models.CharField(max_length=50, verbose_name='Группа', blank=True)
    kurs = models.IntegerField(null=True, blank=True, verbose_name='Курс')
    obuch = models.CharField(max_length=100, verbose_name='Форма обучения', blank=True)
    spec = models.CharField(max_length=200, verbose_name='Специальность', blank=True)
    vid = models.CharField(max_length=100, verbose_name='Вид практики', blank=True)
    kod = models.CharField(max_length=50, verbose_name='Код', blank=True)
    adress = models.CharField(max_length=300, verbose_name='Адрес практики', blank=True)
    ruka = models.CharField(max_length=200, verbose_name='Руководитель', blank=True)
    
    def __str__(self):
        return self.fio or self.user.username

class DocumentTemplate(models.Model):
    name = models.CharField(max_length=100, verbose_name='Название')
    doc_type = models.CharField(max_length=50, verbose_name='Тип документа')
    description = models.TextField(blank=True, verbose_name='Описание')
    template_file = models.FileField(upload_to='templates/', verbose_name='Файл шаблона')
    created_at = models.DateTimeField(auto_now_add=True)
    
    def __str__(self):
        return self.name

class GeneratedDocument(models.Model):
    user = models.ForeignKey(User, on_delete=models.CASCADE)
    template = models.ForeignKey(DocumentTemplate, on_delete=models.SET_NULL, null=True)
    document_file = models.FileField(upload_to='generated/')
    created_at = models.DateTimeField(auto_now_add=True)
    
    def __str__(self):
        return f"{self.user.username} - {self.created_at}"