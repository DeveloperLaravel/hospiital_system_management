# TODO - إضافة الصلاحيات للسجلات الطبية

## [x] الخطوة 1: تحديث MedicalRecordManager.php
- [x] إضافة use Auth
- [x] إضافة دالة canView()
- [x] إضافة دالة canCreate()
- [x] إضافة دالة canEdit($record)
- [x] إضافة دالة canDelete($record)
- [x] تحديث دالة render()
- [x] تحديث دالة create()
- [x] تحديث دالة edit()
- [x] تحديث دالة store()
- [x] تحديث دالة delete()

## [x] الخطوة 2: تحديث medical-record-manager.blade.php
- [x] إخفاء زر "سجل جديد" إذا لا توجد صلاحية
- [x] إخفاء زر التعديل إذا لا توجد صلاحية
- [x] إخفاء زر الحذف إذا لا توجد صلاحية
- [x] عرض رسالة عند عدم وجود صلاحية

