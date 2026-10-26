<?php require_once 'config.php';
require_login();
$title = 'لوحة التحكم';
$u = user();
require 'includes/header.php'; ?><h1>لوحة التحكم</h1>
<p>أهلاً <?= h($u['full_name']) ?> — نوع الحساب: <?= h(['customer' => 'زبون', 'provider' => 'مقدم خدمة', 'admin' => 'مدير النظام'][$u['role']] ?? $u['role']) ?></p>
<div class="grid">
    <?php if ($u['role'] === 'customer'): ?><div class="card">
            <h3>البحث عن مقدمي الخدمات</h3>
            <p>استعرضي الملفات والأسعار والمواعيد.</p><a class="btn" href="providers.php">عرض مقدمي الخدمات</a>
        </div>
        <div class="card">
            <h3>حجوزاتي</h3>
            <p>عرض الحجوزات ومتابعة حالتها.</p><a class="btn" href="my_appointments.php">حجوزاتي</a>
        </div>

    <?php elseif ($u['role'] === 'provider'): ?><!-- شبكة الحاويات الأربعة لمقدم الخدمة -->
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; margin-top: 24px;">

            <!-- الحاوية الأولى: إدارة الملف الشخصي -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); display: flex; flex-direction: column; justify-content: space-between;">
                <div style="display: flex; align-items: flex-start; gap: 16px; margin-bottom: 20px;">
                    <div style="width: 52px; height: 52px; border-radius: 12px; background-color: #f1f5f9; color: #0B192C; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div>
                        <h3 style="margin: 0 0 6px 0; font-size: 18px; font-weight: 700; color: #0f172a;">إدارة الملف الشخصي</h3>
                        <p style="margin: 0; font-size: 13px; color: #64748b; line-height: 1.6;">تحديث البيانات الشخصية، السيرة الذاتية، التخصص، ورسوم الجلسات الاستشارية.</p>
                    </div>
                </div>
                <a href="provider_edit.php" style="background-color: #0B192C; color: #ffffff; text-align: center; padding: 12px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 600; display: block;">تعديل الملف</a>
            </div>

            <!-- الحاوية الثانية: إدارة المواعيد -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); display: flex; flex-direction: column; justify-content: space-between;">
                <div style="display: flex; align-items: flex-start; gap: 16px; margin-bottom: 20px;">
                    <div style="width: 52px; height: 52px; border-radius: 12px; background-color: #f1f5f9; color: #0B192C; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <div>
                        <h3 style="margin: 0 0 6px 0; font-size: 18px; font-weight: 700; color: #0f172a;">إدارة المواعيد</h3>
                        <p style="margin: 0; font-size: 13px; color: #64748b; line-height: 1.6;">متابعة المواعيد المحجوزة، استعراض جدول الجلسات وقائمة العملاء.</p>
                    </div>
                </div>
                <a href="manage_appointments.php" style="background-color: #0B192C; color: #ffffff; text-align: center; padding: 12px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 600; display: block;">عرض المواعيد</a>
            </div>

            <!-- الحاوية الثالثة: ساعات العمل والتوفر -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); display: flex; flex-direction: column; justify-content: space-between;">
                <div style="display: flex; align-items: flex-start; gap: 16px; margin-bottom: 20px;">
                    <div style="width: 52px; height: 52px; border-radius: 12px; background-color: #f1f5f9; color: #0B192C; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </div>
                    <div>
                        <h3 style="margin: 0 0 6px 0; font-size: 18px; font-weight: 700; color: #0f172a;">ساعات العمل والتوفر</h3>
                        <p style="margin: 0; font-size: 13px; color: #64748b; line-height: 1.6;">تحديد وإضافة الأوقات والأيام المتاحة لاستقبال حجوزات العملاء الجديدة.</p>
                    </div>
                </div>
                <a href="manage_availability.php" style="background-color: #0B192C; color: #ffffff; text-align: center; padding: 12px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 600; display: block;">ضبط أوقات التوفر</a>
            </div>

            <!-- الحاوية الرابعة: المعاملات المالية -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); display: flex; flex-direction: column; justify-content: space-between;">
                <div style="display: flex; align-items: flex-start; gap: 16px; margin-bottom: 20px;">
                    <div style="width: 52px; height: 52px; border-radius: 12px; background-color: #f1f5f9; color: #0B192C; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                            <line x1="2" y1="10" x2="22" y2="10"></line>
                        </svg>
                    </div>
                    <div>
                        <h3 style="margin: 0 0 6px 0; font-size: 18px; font-weight: 700; color: #0f172a;">المعاملات المالية</h3>
                        <p style="margin: 0; font-size: 13px; color: #64748b; line-height: 1.6;">متابعة الدفعات المستلمة، أرباح الجلسات الاستشارية، وسجل عمليات السداد.</p>
                    </div>
                </div>
                <a href="financial_transactions.php" style="background-color: #0B192C; color: #ffffff; text-align: center; padding: 12px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 600; display: block;">عرض السجل المالي</a>
            </div>

        </div>

    <?php else: ?>
        <!-- قسم المدير (Admin) -->
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; margin-top: 24px;">

            <!-- الحاوية الأولى: إدارة الملف الشخصي -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); display: flex; flex-direction: column; justify-content: space-between;">
                <div style="display: flex; align-items: flex-start; gap: 16px; margin-bottom: 20px;">
                    <div style="width: 52px; height: 52px; border-radius: 12px; background-color: #f1f5f9; color: #0B192C; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div>
                        <h3 style="margin: 0 0 6px 0; font-size: 18px; font-weight: 700; color: #0f172a;">إدارة الملف الشخصي</h3>
                        <p style="margin: 0; font-size: 13px; color: #64748b; line-height: 1.6;">تحديث البيانات الشخصية، السيرة الذاتية، التخصص، ورسوم الجلسات الاستشارية.</p>
                    </div>
                </div>
                <a href="provider_edit.php" style="background-color: #0B192C; color: #ffffff; text-align: center; padding: 12px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 600; display: block;">تعديل الملف</a>
            </div>

            <!-- الحاوية الثانية: إدارة المواعيد -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); display: flex; flex-direction: column; justify-content: space-between;">
                <div style="display: flex; align-items: flex-start; gap: 16px; margin-bottom: 20px;">
                    <div style="width: 52px; height: 52px; border-radius: 12px; background-color: #f1f5f9; color: #0B192C; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <div>
                        <h3 style="margin: 0 0 6px 0; font-size: 18px; font-weight: 700; color: #0f172a;">إدارة المواعيد</h3>
                        <p style="margin: 0; font-size: 13px; color: #64748b; line-height: 1.6;">متابعة المواعيد المحجوزة، استعراض جدول الجلسات وقائمة العملاء.</p>
                    </div>
                </div>
                <a href="manage_appointments.php" style="background-color: #0B192C; color: #ffffff; text-align: center; padding: 12px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 600; display: block;">عرض المواعيد</a>
            </div>

            <!-- الحاوية الثالثة: ساعات العمل والتوفر -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); display: flex; flex-direction: column; justify-content: space-between;">
                <div style="display: flex; align-items: flex-start; gap: 16px; margin-bottom: 20px;">
                    <div style="width: 52px; height: 52px; border-radius: 12px; background-color: #f1f5f9; color: #0B192C; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </div>
                    <div>
                        <h3 style="margin: 0 0 6px 0; font-size: 18px; font-weight: 700; color: #0f172a;">ساعات العمل والتوفر</h3>
                        <p style="margin: 0; font-size: 13px; color: #64748b; line-height: 1.6;">تحديد وإضافة الأوقات والأيام المتاحة لاستقبال حجوزات العملاء الجديدة.</p>
                    </div>
                </div>
                <a href="manage_availability.php" style="background-color: #0B192C; color: #ffffff; text-align: center; padding: 12px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 600; display: block;">ضبط أوقات التوفر</a>
            </div>

            <!-- الحاوية الرابعة: المعاملات المالية -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); display: flex; flex-direction: column; justify-content: space-between;">
                <div style="display: flex; align-items: flex-start; gap: 16px; margin-bottom: 20px;">
                    <div style="width: 52px; height: 52px; border-radius: 12px; background-color: #f1f5f9; color: #0B192C; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                            <line x1="2" y1="10" x2="22" y2="10"></line>
                        </svg>
                    </div>
                    <div>
                        <h3 style="margin: 0 0 6px 0; font-size: 18px; font-weight: 700; color: #0f172a;">المعاملات المالية</h3>
                        <p style="margin: 0; font-size: 13px; color: #64748b; line-height: 1.6;">متابعة الدفعات المستلمة، أرباح الجلسات الاستشارية، وسجل عمليات السداد.</p>
                    </div>
                </div>
                <a href="financial_transactions.php" style="background-color: #0B192C; color: #ffffff; text-align: center; padding: 12px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 600; display: block;">عرض السجل المالي</a>
            </div>

        </div>


    <?php endif; ?>
</div><?php require 'includes/footer.php'; ?>