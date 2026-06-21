# mainKAA/admin.py
from django.contrib import admin
from .models import DocumentTemplate, GeneratedDocument, StudentProfile

class DocumentTemplateAdmin(admin.ModelAdmin):
    list_display = ['id', 'name', 'doc_type', 'created_at']
    list_filter = ['doc_type', 'created_at']
    search_fields = ['name', 'description']
    fieldsets = (
        ('Основная информация', {
            'fields': ('name', 'doc_type', 'description')
        }),
        ('Файл шаблона', {
            'fields': ('template_file',),
            'description': 'Загрузите файл .docx с переменными в формате {{ переменная }}'
        }),
    )

class StudentProfileAdmin(admin.ModelAdmin):
    list_display = ['user', 'fio', 'grupa', 'kurs', 'vid']
    list_filter = ['obuch', 'vid', 'kurs']
    search_fields = ['fio', 'grupa', 'user__username']

admin.site.register(DocumentTemplate, DocumentTemplateAdmin)
admin.site.register(GeneratedDocument)
admin.site.register(StudentProfile, StudentProfileAdmin)