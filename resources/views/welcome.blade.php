<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مرحبا بك في إدارة مستشفى الشروق</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Almarai', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Hero Section -->
    <section class="relative bg-blue-600 text-white min-h-screen flex items-center">
        <div class="container mx-auto px-6 md:px-12 text-center z-10 relative">
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-4">مرحباً بك في نظام إدارة مستشفى الشروق</h1>
            <p class="text-base sm:text-lg md:text-xl lg:text-2xl mb-8">نظام متكامل لإدارة المرضى، الأطباء، الأقسام والمواعيد بكل سهولة وأمان.</p>
            <a href="#features" class="bg-white text-blue-600 px-6 py-3 sm:px-8 sm:py-4 rounded-xl font-semibold hover:bg-gray-100 transition">استكشاف النظام</a>
        </div>
        <!-- Hero Image -->
        <img src="{{ asset('images/1.png') }}"
             alt="مستشفى الشروق"
             class="absolute bottom-0 right-0 w-1/2 sm:w-1/3 md:w-1/4 lg:w-1/5 hidden md:block rounded-lg shadow-lg">
        <!-- Overlay gradient for better text readability -->
        <div class="absolute inset-0 bg-gradient-to-t from-blue-700 via-transparent to-transparent"></div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 md:py-20 bg-gray-50">
        <div class="container mx-auto px-6 md:px-12 text-center">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-12">ميزات النظام</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-10">
                <div class="bg-white p-5 sm:p-6 md:p-8 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="font-bold text-lg sm:text-xl md:text-2xl mb-2">إدارة المرضى</h3>
                    <p class="text-sm sm:text-base md:text-lg">تسجيل المرضى، متابعة التاريخ الطبي، وعرض جميع بيانات المرضى بشكل منظم.</p>
                </div>
                <div class="bg-white p-5 sm:p-6 md:p-8 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="font-bold text-lg sm:text-xl md:text-2xl mb-2">إدارة الأطباء</h3>
                    <p class="text-sm sm:text-base md:text-lg">إضافة الأطباء، تخصيص الأقسام، وإدارة جداول العمل والمواعيد.</p>
                </div>
                <div class="bg-white p-5 sm:p-6 md:p-8 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="font-bold text-lg sm:text-xl md:text-2xl mb-2">الأقسام والإجراءات</h3>
                    <p class="text-sm sm:text-base md:text-lg">إدارة جميع أقسام المستشفى مع تحديد الصلاحيات لكل قسم بسهولة.</p>
                </div>
                <div class="bg-white p-5 sm:p-6 md:p-8 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="font-bold text-lg sm:text-xl md:text-2xl mb-2">المواعيد والجدولة</h3>
                    <p class="text-sm sm:text-base md:text-lg">حجز المواعيد بسهولة، متابعة حالة المرضى، وإرسال تذكيرات تلقائية.</p>
                </div>
                <div class="bg-white p-5 sm:p-6 md:p-8 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="font-bold text-lg sm:text-xl md:text-2xl mb-2">المخزون والصيدلية</h3>
                    <p class="text-sm sm:text-base md:text-lg">متابعة الأدوية، الأجهزة الطبية، وإدارة المخزون بشكل آمن ودقيق.</p>
                </div>
                <div class="bg-white p-5 sm:p-6 md:p-8 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="font-bold text-lg sm:text-xl md:text-2xl mb-2">التقارير والتحليلات</h3>
                    <p class="text-sm sm:text-base md:text-lg">عرض تقارير يومية، إحصائيات، ومتابعة أداء المستشفى والكوادر.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Permissions Section -->
    <section class="py-16 md:py-20 bg-blue-600 text-white">
        <div class="container mx-auto px-6 md:px-12 text-center">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-12">الصلاحيات المتوفرة</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-10 text-right">
                <div class="bg-blue-500 p-5 sm:p-6 md:p-8 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="font-bold text-lg sm:text-xl md:text-2xl mb-2">صلاحيات المشرف</h3>
                    <ul class="list-disc list-inside text-sm sm:text-base md:text-lg">
                        <li>إدارة المستخدمين</li>
                        <li>تعيين الأدوار والصلاحيات</li>
                        <li>الإشراف على كل الأقسام</li>
                    </ul>
                </div>
                <div class="bg-blue-500 p-5 sm:p-6 md:p-8 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="font-bold text-lg sm:text-xl md:text-2xl mb-2">صلاحيات الأطباء</h3>
                    <ul class="list-disc list-inside text-sm sm:text-base md:text-lg">
                        <li>عرض وإدارة المرضى</li>
                        <li>حجز المواعيد وإدارتها</li>
                        <li>إضافة التقارير الطبية</li>
                    </ul>
                </div>
                <div class="bg-blue-500 p-5 sm:p-6 md:p-8 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="font-bold text-lg sm:text-xl md:text-2xl mb-2">صلاحيات الموظفين</h3>
                    <ul class="list-disc list-inside text-sm sm:text-base md:text-lg">
                        <li>إدخال بيانات المرضى</li>
                        <li>إدارة المخزون والأدوية</li>
                        <li>تنفيذ العمليات اليومية للمديرية</li>
                    </ul>
                </div>
            </div>
            <p class="mt-8 text-sm sm:text-base md:text-lg">كل الصلاحيات مصممة لضمان أمان البيانات وسهولة إدارة المستشفى بكفاءة عالية.</p>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-16 md:py-20 bg-gray-50 text-center">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-6">ابدأ الآن في إدارة المستشفى بكفاءة</h2>
        <a href="/login" class="bg-blue-600 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-xl font-semibold hover:bg-blue-700 transition">تسجيل الدخول</a>
    </section>

</body>
</html>
