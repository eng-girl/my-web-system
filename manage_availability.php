<?php
require_once 'config.php';
include 'includes/header.php';
?>

<div style="max-width: 1200px; margin: 40px auto; padding: 0 20px; direction: rtl; text-align: right; font-family: inherit;">

    <!-- القسم العلوي: ملخص الإحصائيات الذكية -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; margin-bottom: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px; margin-bottom: 16px;">
            <div>
                <h1 style="font-size: 20px; font-weight: 700; color: #0f172a; margin: 0 0 6px 0;">إعدادات أوقات العمل وجدولة الجلسات الذكية</h1>
                <p style="font-size: 13px; color: #64748b; margin: 0;">أعرض هذه الأوقات مباشرة للعملاء والمستفيدين في دليل الحجز الإلكتروني الموثق. يقوم النظام تلقائياً بمنع التعارضات مع التقويم الخارجي المرتبط عبر</p>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; border-top: 1px solid #f1f5f9; padding-top: 20px;">
            <div style="display: flex; align-items: center; gap: 12px; background: #f8fafc; padding: 12px 16px; border-radius: 12px; border: 1px solid #e2e8f0;">
                <div style="font-size: 20px;">📅</div>
                <div>
                    <div style="font-size: 11px; color: #64748b;">أيام العمل المتاحة</div>
                    <div style="font-size: 14px; font-weight: 700; color: #0f172a;">5 أيام / أسبوع</div>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 12px; background: #f8fafc; padding: 12px 16px; border-radius: 12px; border: 1px solid #e2e8f0;">
                <div style="font-size: 20px;">⏳</div>
                <div>
                    <div style="font-size: 11px; color: #64748b;">الساعات المجدولة أسبوعياً</div>
                    <div style="font-size: 14px; font-weight: 700; color: #0f172a;">34.5 ساعة</div>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 12px; background: #f8fafc; padding: 12px 16px; border-radius: 12px; border: 1px solid #e2e8f0;">
                <div style="font-size: 20px;">🔗</div>
                <div>
                    <div style="font-size: 11px; color: #64748b;">التقويم المتصل</div>
                    <div style="font-size: 14px; font-weight: 700; color: #0B192C;">Google Calendar</div>
                </div>
            </div>
        </div>
    </div>

    <!-- المحتوى الرئيسي (إعدادات الفترات والأيام) -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
        <h2 style="font-size: 17px; font-weight: 700; color: #0f172a; margin: 0 0 4px 0;">إعدادات أوقات العمل وجدولة الجلسات الذكية</h2>
        <p style="font-size: 13px; color: #64748b; margin: 0 0 24px 0;">تخصيص الفترات الصباحية والمسائية مع إمكانية تجزئة الوردات لكل يوم</p>

        <!-- الأيام والفترات -->
        <div style="display: flex; flex-direction: column; gap: 20px;">

            <!-- بطاقة يوم الأحد -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px 24px; box-shadow: 0 1px 2px rgba(0,0,0,0.02);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 20px;">

                    <!-- الفترات الزمنية وزر الإضافة في اليمين -->
                    <div style="flex: 1; display: flex; flex-direction: column; gap: 12px;">
                        <div class="slots-container" style="display: flex; flex-direction: column; gap: 10px;">
                            <div style="border: 1px solid #cbd5e1; border-radius: 12px; padding: 12px 16px; background: #ffffff; font-size: 14px; color: #0f172a; text-align: left;" dir="ltr">
                                من 09:00 AM إلى 01:00 PM
                            </div>
                            <div style="border: 1px solid #cbd5e1; border-radius: 12px; padding: 12px 16px; background: #ffffff; font-size: 14px; color: #0f172a; text-align: left;" dir="ltr">
                                من 04:30 PM إلى 08:30 PM
                            </div>
                        </div>
                        <div>
                            <button type="button" onclick="addNewSlot(this)" style="background: none; border: none; color: #0B192C; font-size: 13px; font-weight: 700; cursor: pointer; padding: 4px 0; display: inline-flex; align-items: center; gap: 4px;">
                                + فترة جديدة
                            </button>
                        </div>
                    </div>

                    <!-- زر التفعيل واسم اليوم في اليسار -->
                    <div style="display: flex; align-items: center; gap: 12px; flex-shrink: 0; padding-top: 4px;">
                        <span style="font-size: 16px; font-weight: 700; color: #0f172a;">الأحد</span>
                        <label style="position: relative; display: inline-block; width: 50px; height: 26px; cursor: pointer;">
                            <input type="checkbox" checked style="opacity: 0; width: 0; height: 0;">
                            <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #10b981; transition: .3s; border-radius: 34px;"></span>
                            <span style="position: absolute; content: ''; height: 20px; width: 20px; left: 4px; bottom: 3px; background-color: white; transition: .3s; border-radius: 50%;"></span>
                        </label>
                    </div>

                </div>
            </div>

            <!-- بطاقة يوم الإثنين -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px 24px; box-shadow: 0 1px 2px rgba(0,0,0,0.02);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 20px;">

                    <div style="flex: 1; display: flex; flex-direction: column; gap: 12px;">
                        <div class="slots-container" style="display: flex; flex-direction: column; gap: 10px;">
                            <div style="border: 1px solid #cbd5e1; border-radius: 12px; padding: 12px 16px; background: #ffffff; font-size: 14px; color: #0f172a; text-align: left;" dir="ltr">
                                من 09:00 AM إلى 02:00 PM
                            </div>
                        </div>
                        <div>
                            <button type="button" onclick="addNewSlot(this)" style="background: none; border: none; color: #0B192C; font-size: 13px; font-weight: 700; cursor: pointer; padding: 4px 0; display: inline-flex; align-items: center; gap: 4px;">
                                + فترة جديدة
                            </button>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; gap: 12px; flex-shrink: 0; padding-top: 4px;">
                        <span style="font-size: 16px; font-weight: 700; color: #0f172a;">الإثنين</span>
                        <label style="position: relative; display: inline-block; width: 50px; height: 26px; cursor: pointer;">
                            <input type="checkbox" checked style="opacity: 0; width: 0; height: 0;">
                            <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #10b981; transition: .3s; border-radius: 34px;"></span>
                            <span style="position: absolute; content: ''; height: 20px; width: 20px; left: 4px; bottom: 3px; background-color: white; transition: .3s; border-radius: 50%;"></span>
                        </label>
                    </div>

                </div>
            </div>

        </div>

        <!-- زر الحفظ -->
        <button type="button" style="background-color: #0B192C; color: #ffffff; width: 100%; padding: 14px; border-radius: 10px; border: none; font-size: 15px; font-weight: 600; cursor: pointer; margin-top: 28px;">حفظ التغييرات</button>
    </div>
</div>

<script>
    function addNewSlot(button) {
        // العثور على حاوية الفترات الخاصة بهذا اليوم
        const cardContent = button.closest('div').parentElement;
        const container = cardContent.querySelector('.slots-container');

        // إنشاء حقل إدخال جديد للفترة
        const newSlotDiv = document.createElement('div');
        newSlotDiv.style.cssText = "display: flex; gap: 8px; align-items: center;";
        newSlotDiv.innerHTML = `
        <input type="text" value="من 02:00 PM إلى 06:00 PM" style="flex: 1; border: 1px solid #cbd5e1; border-radius: 12px; padding: 12px 16px; background: #ffffff; font-size: 14px; color: #0f172a; outline: none; text-align: left;" dir="ltr">
        <button type="button" onclick="this.parentElement.remove()" style="background: #fee2e2; color: #dc2626; border: none; border-radius: 8px; padding: 12px 14px; cursor: pointer; font-size: 12px; font-weight: 600;">حذف</button>
    `;

        container.appendChild(newSlotDiv);
    }
</script>

<?php include 'includes/footer.php'; ?>