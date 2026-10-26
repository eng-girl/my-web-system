<?php
require_once '../config.php';
include '../includes/header.php';
?>

<!-- مكتبة الرسوم البيانية Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    .admin-financial-wrapper {
        max-width: 1400px;
        margin: 30px auto;
        padding: 0 20px;
        direction: rtl;
        text-align: right;
        font-family: inherit;
        color: #0f172a;
    }

    .fin-nav {
        display: flex;
        gap: 8px;
        background: #f1f5f9;
        padding: 6px;
        border-radius: 12px;
        margin-bottom: 24px;
        overflow-x: auto;
    }

    .fin-nav-btn {
        flex: 1;
        white-space: nowrap;
        text-align: center;
        padding: 12px 16px;
        font-size: 14px;
        font-weight: 700;
        color: #64748b;
        border-radius: 8px;
        cursor: pointer;
        border: none;
        background: transparent;
        transition: all 0.2s;
    }

    .fin-nav-btn.active {
        background: #0B192C;
        color: #ffffff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .fin-section {
        display: none;
    }

    .fin-section.active {
        display: block;
    }

    /* KPI Cards */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    }

    .kpi-title {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 6px;
        font-weight: 600;
    }

    .kpi-val {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
    }

    /* Filter Bar */
    .filter-bar {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .fin-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        text-align: right;
    }

    .fin-table th {
        background: #f8fafc;
        color: #64748b;
        padding: 12px 16px;
        font-weight: 700;
        border-bottom: 1px solid #e2e8f0;
    }

    .fin-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        display: inline-block;
    }

    .badge-success {
        background: #dcfce7;
        color: #15803d;
    }

    .badge-pending {
        background: #fef9c3;
        color: #a16207;
    }

    .badge-failed {
        background: #fee2e2;
        color: #b91c1c;
    }

    .badge-info {
        background: #e0f2fe;
        color: #0369a1;
    }

    /* Modal Side Drawer */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(15, 23, 42, 0.4);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal-box {
        background: #fff;
        border-radius: 16px;
        width: 90%;
        max-width: 600px;
        padding: 24px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        max-height: 90vh;
        overflow-y: auto;
    }
</style>

<div class="admin-financial-wrapper">

    <!-- الترويسة العليا -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0 0 4px 0;">إدارة الشؤون المالية والإيرادات</h1>
            <p style="font-size: 13px; color: #64748b; margin: 0;">متابعة الأرباح، العمولة، مستحقات الخبراء، السحوبات والمبالغ المستردة.</p>
        </div>
        <button onclick="exportToCSV()" style="background: #0B192C; color: #fff; border: none; padding: 10px 18px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
            📥 تصدير التقرير (CSV)
        </button>
    </div>

    <!-- 2. شريط التنقل الرئيسي للقسم المالي -->
    <div class="fin-nav">
        <button class="fin-nav-btn active" onclick="switchTab('overview', this)">نظرة عامة مالية</button>
        <button class="fin-nav-btn" onclick="switchTab('payments', this)">المدفوعات</button>
        <button class="fin-nav-btn" onclick="switchTab('revenue', this)">إيرادات المنصة</button>
        <button class="fin-nav-btn" onclick="switchTab('earnings', this)">مستحقات مقدمي الخدمات</button>
        <button class="fin-nav-btn" onclick="switchTab('payouts', this)">التحويلات المالية</button>
        <button class="fin-nav-btn" onclick="switchTab('refunds', this)">المبالغ المستردة</button>
    </div>

    <!-- فلتر التاريخ العام -->
    <div class="filter-bar">
        <div style="display: flex; gap: 10px; align-items: center;">
            <span style="font-size: 13px; font-weight: 700; color: #475569;">النطاق الزمني:</span>
            <select id="dateFilter" onchange="applyFilters()" style="padding: 8px 14px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; outline: none;">
                <option value="all">كافة الأوقات</option>
                <option value="today">اليوم</option>
                <option value="last7">آخر 7 أيام</option>
                <option value="last30">آخر 30 يوماً</option>
                <option value="thisMonth">هذا الشهر</option>
            </select>
        </div>
        <div style="display: flex; gap: 10px;">
            <input type="text" id="globalSearch" placeholder="بحث باسم العميل، الخبير أو المعاملة..." onkeyup="applyFilters()" style="padding: 8px 14px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 13px; width: 260px; outline: none;">
        </div>
    </div>

    <!-- 3. قسم 1: النظرة العامة المالية (Financial Overview) -->
    <div id="sec-overview" class="fin-section active">
        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-title">إجمالي قيمة المعاملات (Gross Value)</div>
                <div class="kpi-val" id="kpi-gross">0.00 د.ل</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-title">إجمالي عمولة المنصة (15%)</div>
                <div class="kpi-val" style="color: #059669;" id="kpi-commission">0.00 د.ل</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-title">رسوم معالجة الدفع</div>
                <div class="kpi-val" style="color: #64748b;" id="kpi-fees">0.00 د.ل</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-title">المبالغ المستردة (Refunds)</div>
                <div class="kpi-val" style="color: #dc2626;" id="kpi-refunds">0.00 د.ل</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-title">مستحقات الخبراء المعلقة</div>
                <div class="kpi-val" style="color: #d97706;" id="kpi-outstanding">0.00 د.ل</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-title">إجمالي التحويلات المكتملة</div>
                <div class="kpi-val" style="color: #2563eb;" id="kpi-payouts">0.00 د.ل</div>
            </div>
        </div>

        <!-- الرسم البياني -->
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 24px;">
            <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px;">
                <h4 style="margin: 0 0 16px 0; font-size: 15px;">نمو الإيرادات والعمولة عبر الوقت</h4>
                <canvas id="revenueChart" height="110"></canvas>
            </div>
            <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px;">
                <h4 style="margin: 0 0 16px 0; font-size: 15px;">توزيع حالات المدفوعات</h4>
                <canvas id="statusChart" height="180"></canvas>
            </div>
        </div>

        <!-- المعاملات الأخيرة -->
        <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px;">
            <h4 style="margin: 0 0 16px 0; font-size: 15px;">أحدث المعاملات المالية</h4>
            <table class="fin-table">
                <thead>
                    <tr>
                        <th>المعاملة</th>
                        <th>العميل</th>
                        <th>مقدم الخدمة</th>
                        <th>المبلغ الإجمالي</th>
                        <th>عمولة المنصة</th>
                        <th>الحالة</th>
                    </tr>
                </thead>
                <tbody id="overview-recent-table"></tbody>
            </table>
        </div>
    </div>

    <!-- 4. قسم 2: المدفوعات (Payments Page) -->
    <div id="sec-payments" class="fin-section">
        <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px;">
            <h4 style="margin: 0 0 16px 0; font-size: 16px;">سجل مدفوعات العملاء</h4>
            <table class="fin-table">
                <thead>
                    <tr>
                        <th>رمز المعاملة</th>
                        <th>الحجز</th>
                        <th>اسم العميل</th>
                        <th>مقدم الخدمة</th>
                        <th>نوع الخدمة</th>
                        <th>الإجمالي</th>
                        <th>وسيلة الدفع</th>
                        <th>التاريخ</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody id="payments-tbody"></tbody>
            </table>
        </div>
    </div>

    <!-- 5. قسم 3: إيرادات المنصة (Platform Revenue Page) -->
    <div id="sec-revenue" class="fin-section">
        <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 14px; padding: 20px; margin-bottom: 20px;">
            <h4 style="margin: 0 0 10px 0; font-size: 15px; color: #0B192C;">⚙️ إعدادات نسبة عمولة المنصة</h4>
            <div style="display: flex; gap: 16px; align-items: center;">
                <span style="font-size: 13px;">العمولة الافتراضية الحالية: <strong>15%</strong></span>
                <input type="number" id="commissionInput" value="15" style="width: 80px; padding: 6px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 13px;">
                <button onclick="updateCommissionRule()" style="background: #0B192C; color: #fff; border: none; padding: 8px 14px; border-radius: 6px; font-size: 12px; cursor: pointer;">حفظ النسبة الجديدة للمستقبل</button>
            </div>
            <p style="font-size: 11px; color: #64748b; margin: 8px 0 0 0;">* تطبيق النسبة الجديدة يسري على الحجوزات المستقبلية فقط دون التعديل على السجلات التاريخية.</p>
        </div>

        <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px;">
            <h4 style="margin: 0 0 16px 0; font-size: 16px;">جدول الأرباح الصافية للمنصة</h4>
            <table class="fin-table">
                <thead>
                    <tr>
                        <th>التاريخ</th>
                        <th>رمز الحجز</th>
                        <th>الخبير</th>
                        <th>مبلغ الخدمة</th>
                        <th>نسبة العمولة</th>
                        <th>قيمة العمولة</th>
                        <th>رسوم المعالجة</th>
                        <th>الاسترداد</th>
                        <th>صافي أرباح المنصة</th>
                    </tr>
                </thead>
                <tbody id="revenue-tbody"></tbody>
            </table>
        </div>
    </div>

    <!-- 6. قسم 4: مستحقات مقدمي الخدمات (Provider Earnings Page) -->
    <div id="sec-earnings" class="fin-section">
        <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px;">
            <h4 style="margin: 0 0 16px 0; font-size: 16px;">أرصدة ومستحقات مقدمي الخدمات</h4>
            <table class="fin-table">
                <thead>
                    <tr>
                        <th>الخبير</th>
                        <th>الجلسات المكتملة</th>
                        <th>إجمالي الاستشارات</th>
                        <th>خصم العمولة (15%)</th>
                        <th>صافي الأرباح المستحقة</th>
                        <th>المبالغ المسددة</th>
                        <th>الرصيد المتاح للسحب</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody id="earnings-tbody"></tbody>
            </table>
        </div>
    </div>

    <!-- 7. قسم 5: التحويلات المالية (Payouts Page) -->
    <div id="sec-payouts" class="fin-section">
        <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px;">
            <h4 style="margin: 0 0 16px 0; font-size: 16px;">طلبات تحويل مستحقات الخبراء</h4>
            <table class="fin-table">
                <thead>
                    <tr>
                        <th>رمز التحويل</th>
                        <th>الخبير</th>
                        <th>المبلغ المطلوب</th>
                        <th>الحساب المالي (مخفي)</th>
                        <th>تاريخ الطلب</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody id="payouts-tbody"></tbody>
            </table>
        </div>
    </div>

    <!-- 8. قسم 6: المبالغ المستردة (Refunds Page) -->
    <div id="sec-refunds" class="fin-section">
        <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px;">
            <h4 style="margin: 0 0 16px 0; font-size: 16px;">طلبات الاسترداد والإلغاء</h4>
            <table class="fin-table">
                <thead>
                    <tr>
                        <th>رمز الاسترداد</th>
                        <th>الحجز</th>
                        <th>العميل</th>
                        <th>الخبير</th>
                        <th>المبلغ الأصلي</th>
                        <th>المبلغ المسترد</th>
                        <th>سبب الاسترداد</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody id="refunds-tbody"></tbody>
            </table>
        </div>
    </div>

</div>

<!-- نافذة التفاصيل والمراجعة (Modal Window) -->
<div id="detailsModal" class="modal-overlay">
    <div class="modal-box">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px; margin-bottom: 16px;">
            <h3 id="modalTitle" style="margin: 0; font-size: 18px; color: #0f172a;">تفاصيل المعاملة</h3>
            <button onclick="closeModal()" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #64748b;">✕</button>
        </div>
        <div id="modalBody" style="font-size: 13px; line-height: 1.8; color: #334155;"></div>
    </div>
</div>

<script>
    // 10. Centralized Data Model (محاكاة البيانات المركبة)
    const mockData = {
        transactions: [{
                id: 'TX-1001',
                bookingId: 'APT-9101',
                customer: 'أحمد محمود',
                provider: 'د. طارق الجروشي',
                service: 'استشارة هندسة شبكات',
                gross: 250,
                fee: 5,
                date: '2026-10-25',
                status: 'Successful',
                method: 'كرت مسبق الدفع'
            },
            {
                id: 'TX-1002',
                bookingId: 'APT-9102',
                customer: 'سارة المنصور',
                provider: 'م. رحمة علي',
                service: 'تصميم واجهات UI/UX',
                gross: 875,
                fee: 15,
                date: '2026-10-24',
                status: 'Successful',
                method: 'كرت مسبق الدفع'
            },
            {
                id: 'TX-1003',
                bookingId: 'APT-9103',
                customer: 'خالد الزوي',
                provider: 'د. طارق الجروشي',
                service: 'استشارة شبكات',
                gross: 300,
                fee: 6,
                date: '2026-10-24',
                status: 'Successful',
                method: 'كرت مسبق الدفع'
            },
            {
                id: 'TX-1004',
                bookingId: 'APT-9104',
                customer: 'عمر القادري',
                provider: 'م. أيمن الشريف',
                service: 'تطوير تطبيقات',
                gross: 400,
                fee: 8,
                date: '2026-10-23',
                status: 'Fully Refunded',
                method: 'كرت مسبق الدفع'
            },
            {
                id: 'TX-1005',
                bookingId: 'APT-9105',
                customer: 'فاطمة الفيتوري',
                provider: 'م. رحمة علي',
                service: 'تدقيق نظام UI/UX',
                gross: 500,
                fee: 10,
                date: '2026-10-22',
                status: 'Successful',
                method: 'كرت مسبق الدفع'
            },
            {
                id: 'TX-1006',
                bookingId: 'APT-9106',
                customer: 'محمد الورفلي',
                provider: 'د. طارق الجروشي',
                service: 'أمن معلومات',
                gross: 350,
                fee: 7,
                date: '2026-10-20',
                status: 'Successful',
                method: 'كرت مسبق الدفع'
            },
            {
                id: 'TX-1007',
                bookingId: 'APT-9107',
                customer: 'ليلى الترهوني',
                provider: 'م. أسماء الكيلاني',
                service: 'قواعد بيانات MySQL',
                gross: 200,
                fee: 4,
                date: '2026-10-18',
                status: 'Successful',
                method: 'كرت مسبق الدفع'
            },
            {
                id: 'TX-1008',
                bookingId: 'APT-9108',
                customer: 'إبراهيم السنوسي',
                provider: 'م. أيمن الشريف',
                service: 'استشارة برمجية',
                gross: 600,
                fee: 12,
                date: '2026-10-15',
                status: 'Pending',
                method: 'كرت مسبق الدفع'
            },
            {
                id: 'TX-1009',
                bookingId: 'APT-9109',
                customer: 'مريم الصادق',
                provider: 'م. رحمة علي',
                service: 'تصميم هوية رقمية',
                gross: 750,
                fee: 15,
                date: '2026-10-12',
                status: 'Successful',
                method: 'كرت مسبق الدفع'
            },
            {
                id: 'TX-1010',
                bookingId: 'APT-9110',
                customer: 'حسن عبيد',
                provider: 'م. هشام بن عيسى',
                service: 'حلول سحابية AWS',
                gross: 900,
                fee: 18,
                date: '2026-10-10',
                status: 'Successful',
                method: 'كرت مسبق الدفع'
            },
            {
                id: 'TX-1011',
                bookingId: 'APT-9111',
                customer: 'منى الهوني',
                provider: 'م. أسماء الكيلاني',
                service: 'تحسين قواعد بيانات',
                gross: 300,
                fee: 6,
                date: '2026-10-08',
                status: 'Successful',
                method: 'كرت مسبق الدفع'
            },
            {
                id: 'TX-1012',
                bookingId: 'APT-9112',
                customer: 'سالم الشيباني',
                provider: 'د. طارق الجروشي',
                service: 'دعم تقني',
                gross: 150,
                fee: 3,
                date: '2026-10-05',
                status: 'Successful',
                method: 'كرت مسبق الدفع'
            },
            {
                id: 'TX-1013',
                bookingId: 'APT-9113',
                customer: 'وليد الغرياني',
                provider: 'م. أيمن الشريف',
                service: 'تطوير مواقع',
                gross: 450,
                fee: 9,
                date: '2026-10-02',
                status: 'Successful',
                method: 'كرت مسبق الدفع'
            },
            {
                id: 'TX-1014',
                bookingId: 'APT-9114',
                customer: 'هند النعاس',
                provider: 'م. رحمة علي',
                service: 'استشارة تصميم',
                gross: 300,
                fee: 6,
                date: '2026-09-28',
                status: 'Successful',
                method: 'كرت مسبق الدفع'
            },
            {
                id: 'TX-1015',
                bookingId: 'APT-9115',
                customer: 'طارق البوسيفي',
                provider: 'م. هشام بن عيسى',
                service: 'شبكات متقدمة',
                gross: 800,
                fee: 16,
                date: '2026-09-25',
                status: 'Failed',
                method: 'كرت مسبق الدفع'
            }
        ],
        providers: [{
                id: 'PRV-101',
                name: 'د. طارق الجروشي',
                completed: 5,
                gross: 1050,
                settled: 500
            },
            {
                id: 'PRV-102',
                name: 'م. رحمة علي',
                completed: 4,
                gross: 2625,
                settled: 1500
            },
            {
                id: 'PRV-103',
                name: 'م. أيمن الشريف',
                completed: 2,
                gross: 850,
                settled: 200
            },
            {
                id: 'PRV-104',
                name: 'م. أسماء الكيلاني',
                completed: 2,
                gross: 500,
                settled: 0
            },
            {
                id: 'PRV-105',
                name: 'م. هشام بن عيسى',
                completed: 1,
                gross: 900,
                settled: 400
            },
            {
                id: 'PRV-106',
                name: 'د. يونس المقريف',
                completed: 0,
                gross: 0,
                settled: 0
            },
            {
                id: 'PRV-107',
                name: 'م. وسام المصراتي',
                completed: 0,
                gross: 0,
                settled: 0
            },
            {
                id: 'PRV-108',
                name: 'م. نجوى القمودي',
                completed: 0,
                gross: 0,
                settled: 0
            }
        ],
        payouts: [{
                id: 'PO-501',
                provider: 'م. رحمة علي',
                amount: 1000,
                acc: '**** **** 4812',
                date: '2026-10-20',
                status: 'Completed'
            },
            {
                id: 'PO-502',
                provider: 'د. طارق الجروشي',
                amount: 500,
                acc: '**** **** 1928',
                date: '2026-10-21',
                status: 'Completed'
            },
            {
                id: 'PO-503',
                provider: 'م. هشام بن عيسى',
                amount: 400,
                acc: '**** **** 9012',
                date: '2026-10-22',
                status: 'Completed'
            },
            {
                id: 'PO-504',
                provider: 'م. رحمة علي',
                amount: 500,
                acc: '**** **** 4812',
                date: '2026-10-24',
                status: 'Pending Review'
            },
            {
                id: 'PO-505',
                provider: 'م. أيمن الشريف',
                amount: 200,
                acc: '**** **** 3311',
                date: '2026-10-25',
                status: 'Approved'
            },
            {
                id: 'PO-506',
                provider: 'د. طارق الجروشي',
                amount: 350,
                acc: '**** **** 1928',
                date: '2026-10-25',
                status: 'Processing'
            },
            {
                id: 'PO-507',
                provider: 'م. أسماء الكيلاني',
                amount: 400,
                acc: '**** **** 7721',
                date: '2026-10-26',
                status: 'Pending Review'
            },
            {
                id: 'PO-508',
                provider: 'م. أيمن الشريف',
                amount: 500,
                acc: '**** **** 3311',
                date: '2026-10-10',
                status: 'Rejected'
            }
        ],
        refunds: [{
                id: 'RF-901',
                txId: 'TX-1004',
                bookingId: 'APT-9104',
                customer: 'عمر القادري',
                provider: 'م. أيمن الشريف',
                original: 400,
                amount: 400,
                reason: 'عدم حضور الخبير في الموعد',
                date: '2026-10-23',
                status: 'Completed'
            },
            {
                id: 'RF-902',
                txId: 'TX-1008',
                bookingId: 'APT-9108',
                customer: 'إبراهيم السنوسي',
                provider: 'م. أيمن الشريف',
                original: 600,
                amount: 600,
                reason: 'إلغاء قبل الجلسة',
                date: '2026-10-16',
                status: 'Pending Review'
            },
            {
                id: 'RF-903',
                txId: 'TX-1015',
                bookingId: 'APT-9115',
                customer: 'طارق البوسيفي',
                provider: 'م. هشام بن عيسى',
                original: 800,
                amount: 800,
                reason: 'خطأ في عملية السداد',
                date: '2026-09-26',
                status: 'Rejected'
            },
            {
                id: 'RF-904',
                txId: 'TX-1002',
                bookingId: 'APT-9102',
                customer: 'سارة المنصور',
                provider: 'م. رحمة علي',
                original: 875,
                amount: 200,
                reason: 'طلب استرداد جزئي لخاطر فني',
                date: '2026-10-25',
                status: 'Processing'
            },
            {
                id: 'RF-905',
                txId: 'TX-1010',
                bookingId: 'APT-9110',
                customer: 'حسن عبيد',
                provider: 'م. هشام بن عيسى',
                original: 900,
                amount: 900,
                reason: 'تغيير جدول المشروع',
                date: '2026-10-11',
                status: 'Approved'
            }
        ]
    };

    let currentCommissionRate = 0.15; // 15% العمولة الافتراضية

    // التنقل بين التبويبات
    function switchTab(tabId, btn) {
        document.querySelectorAll('.fin-section').forEach(s => s.classList.remove('active'));
        document.querySelectorAll('.fin-nav-btn').forEach(b => b.classList.remove('active'));
        document.getElementById('sec-' + tabId).classList.add('active');
        btn.classList.add('active');
    }

    // 9. الدوال الحسابية وتطبيقات الفلترة
    function renderDashboard() {
        const filter = document.getElementById('dateFilter').value;
        const query = document.getElementById('globalSearch').value.toLowerCase();

        // فلترة المعاملات الناجحة
        let filteredTx = mockData.transactions.filter(t => {
            let matchSearch = t.customer.toLowerCase().includes(query) || t.provider.toLowerCase().includes(query) || t.id.toLowerCase().includes(query);
            return matchSearch;
        });

        let totalGross = 0;
        let totalCommission = 0;
        let totalFees = 0;
        let totalRefunds = 0;

        filteredTx.forEach(t => {
            if (t.status === 'Successful') {
                totalGross += t.gross;
                totalCommission += (t.gross * currentCommissionRate);
                totalFees += t.fee;
            } else if (t.status === 'Fully Refunded') {
                totalRefunds += t.gross;
            }
        });

        // تحديث بطاقات KPI
        document.getElementById('kpi-gross').innerText = totalGross.toFixed(2) + ' د.ل';
        document.getElementById('kpi-commission').innerText = totalCommission.toFixed(2) + ' د.ل';
        document.getElementById('kpi-fees').innerText = totalFees.toFixed(2) + ' د.ل';
        document.getElementById('kpi-refunds').innerText = totalRefunds.toFixed(2) + ' د.ل';
        document.getElementById('kpi-outstanding').innerText = (totalGross - totalCommission - 1700).toFixed(2) + ' د.ل';
        document.getElementById('kpi-payouts').innerText = '1900.00 د.ل';

        // تعبئة جدول النظرة العامة
        let recentHtml = '';
        filteredTx.slice(0, 5).forEach(t => {
            recentHtml += `<tr>
            <td font-weight="700">${t.id}</td>
            <td>${t.customer}</td>
            <td>${t.provider}</td>
            <td>${t.gross.toFixed(2)} د.ل</td>
            <td style="color:#059669;">${(t.gross * currentCommissionRate).toFixed(2)} د.ل</td>
            <td><span class="status-badge ${t.status === 'Successful' ? 'badge-success' : 'badge-failed'}">${t.status}</span></td>
        </tr>`;
        });
        document.getElementById('overview-recent-table').innerHTML = recentHtml;

        // تعبئة صفحة المدفوعات (Payments)
        let payHtml = '';
        filteredTx.forEach(t => {
            payHtml += `<tr>
            <td><strong>${t.id}</strong></td>
            <td>${t.bookingId}</td>
            <td>${t.customer}</td>
            <td>${t.provider}</td>
            <td>${t.service}</td>
            <td><strong>${t.gross.toFixed(2)} د.ل</strong></td>
            <td>${t.method}</td>
            <td>${t.date}</td>
            <td><span class="status-badge ${t.status==='Successful'?'badge-success':(t.status==='Pending'?'badge-pending':'badge-failed')}">${t.status}</span></td>
            <td><button onclick="viewTxDetails('${t.id}')" style="background:#0B192C; color:#fff; border:none; padding:4px 10px; border-radius:6px; font-size:11px; cursor:pointer;">التفاصيل</button></td>
        </tr>`;
        });
        document.getElementById('payments-tbody').innerHTML = payHtml;

        // تعبئة صفحة أرباح المنصة (Platform Revenue)
        let revHtml = '';
        filteredTx.forEach(t => {
            let comm = t.status === 'Successful' ? (t.gross * currentCommissionRate) : 0;
            let netRev = comm - t.fee;
            revHtml += `<tr>
            <td>${t.date}</td>
            <td>${t.bookingId}</td>
            <td>${t.provider}</td>
            <td>${t.gross.toFixed(2)} د.ل</td>
            <td>15%</td>
            <td style="color:#059669; font-weight:700;">${comm.toFixed(2)} د.ل</td>
            <td>${t.fee.toFixed(2)} د.ل</td>
            <td style="color:#dc2626;">${t.status === 'Fully Refunded' ? t.gross.toFixed(2) : '0.00'} د.ل</td>
            <td style="font-weight:700;">${netRev > 0 ? netRev.toFixed(2) : '0.00'} د.ل</td>
        </tr>`;
        });
        document.getElementById('revenue-tbody').innerHTML = revHtml;

        // تعبئة مستحقات الخبراء (Provider Earnings)
        let earnHtml = '';
        mockData.providers.forEach(p => {
            let comm = p.gross * currentCommissionRate;
            let netEarn = p.gross - comm;
            let avail = netEarn - p.settled;
            earnHtml += `<tr>
            <td><strong>${p.name}</strong></td>
            <td>${p.completed} جلسات</td>
            <td>${p.gross.toFixed(2)} د.ل</td>
            <td style="color:#dc2626;">-${comm.toFixed(2)} د.ل</td>
            <td style="color:#059669; font-weight:700;">${netEarn.toFixed(2)} د.ل</td>
            <td>${p.settled.toFixed(2)} د.ل</td>
            <td><span class="status-badge ${avail > 0 ? 'badge-success':'badge-pending'}">${avail.toFixed(2)} د.ل</span></td>
            <td><button onclick="viewProviderLedger('${p.name}')" style="background:#f1f5f9; color:#0B192C; border:1px solid #cbd5e1; padding:4px 8px; border-radius:6px; font-size:11px; cursor:pointer;">كشف حساب</button></td>
        </tr>`;
        });
        document.getElementById('earnings-tbody').innerHTML = earnHtml;

        // تعبئة التحويلات (Payouts)
        let poHtml = '';
        mockData.payouts.forEach(po => {
            poHtml += `<tr>
            <td><strong>${po.id}</strong></td>
            <td>${po.provider}</td>
            <td><strong>${po.amount.toFixed(2)} د.ل</strong></td>
            <td dir="ltr">${po.acc}</td>
            <td>${po.date}</td>
            <td><span class="status-badge ${po.status==='Completed'?'badge-success':(po.status==='Approved'?'badge-info':'badge-pending')}">${po.status}</span></td>
            <td>
                ${po.status === 'Pending Review' ? `<button onclick="actionPayout('${po.id}', 'Approve')" style="background:#16a34a; color:#fff; border:none; padding:4px 8px; border-radius:6px; font-size:11px; cursor:pointer;">موافقة</button> <button onclick="actionPayout('${po.id}', 'Reject')" style="background:#dc2626; color:#fff; border:none; padding:4px 8px; border-radius:6px; font-size:11px; cursor:pointer;">رفض</button>` : '<span style="color:#94a3b8; font-size:11px;">مكتمل</span>'}
            </td>
        </tr>`;
        });
        document.getElementById('payouts-tbody').innerHTML = poHtml;

        // تعبئة الاسترداد (Refunds)
        let refHtml = '';
        mockData.refunds.forEach(r => {
            refHtml += `<tr>
            <td><strong>${r.id}</strong></td>
            <td>${r.bookingId}</td>
            <td>${r.customer}</td>
            <td>${r.provider}</td>
            <td>${r.original.toFixed(2)} د.ل</td>
            <td style="color:#dc2626; font-weight:700;">${r.amount.toFixed(2)} د.ل</td>
            <td>${r.reason}</td>
            <td><span class="status-badge ${r.status==='Completed'?'badge-success':'badge-pending'}">${r.status}</span></td>
            <td>
                ${r.status === 'Pending Review' ? `<button onclick="actionRefund('${r.id}', 'Approve')" style="background:#16a34a; color:#fff; border:none; padding:4px 8px; border-radius:6px; font-size:11px; cursor:pointer;">اعتماد الإرجاع</button>` : '<span style="color:#94a3b8; font-size:11px;">معالج</span>'}
            </td>
        </tr>`;
        });
        document.getElementById('refunds-tbody').innerHTML = refHtml;
    }

    function applyFilters() {
        renderDashboard();
    }

    // النوافذ التفاعلية
    function viewTxDetails(txId) {
        let t = mockData.transactions.find(x => x.id === txId);
        let comm = t.gross * currentCommissionRate;
        document.getElementById('modalTitle').innerText = 'تفاصيل المعاملة ' + t.id;
        document.getElementById('modalBody').innerHTML = `
        <p><strong>رمز الحجز:</strong> ${t.bookingId}</p>
        <p><strong>اسم العميل:</strong> ${t.customer}</p>
        <p><strong>مقدم الخدمة:</strong> ${t.provider}</p>
        <p><strong>نوع الخدمة:</strong> ${t.service}</p>
        <hr style="border:none; border-top:1px solid #e2e8f0;">
        <p><strong>إجمالي المبلغ:</strong> ${t.gross.toFixed(2)} د.ل</p>
        <p><strong>عمولة المنصة (15%):</strong> ${comm.toFixed(2)} د.ل</p>
        <p><strong>رسوم المعالجة:</strong> ${t.fee.toFixed(2)} د.ل</p>
        <p><strong>مستحق الخبير الصافي:</strong> ${(t.gross - comm).toFixed(2)} د.ل</p>
    `;
        document.getElementById('detailsModal').style.display = 'flex';
    }

    function viewProviderLedger(name) {
        document.getElementById('modalTitle').innerText = 'كشف حساب الخبير: ' + name;
        document.getElementById('modalBody').innerHTML = `
        <p>سجل الاستشارات المحسوبة لـ <strong>${name}</strong>:</p>
        <ul>
            <li>إجمالي الجلسات المنجزة: 4 جلسات</li>
            <li>إجمالي المستحقات المعتمدة: 2,231.25 د.ل</li>
            <li>التحويلات السابقة المكتملة: 1,500.00 د.ل</li>
            <li>الرصيد القابل للسحب حالياً: 731.25 د.ل</li>
        </ul>
    `;
        document.getElementById('detailsModal').style.display = 'flex';
    }

    function actionPayout(id, action) {
        let po = mockData.payouts.find(x => x.id === id);
        if (confirm(`هل أنت تأكد من إجراء (${action}) للتحويل ${id} بقيمة ${po.amount} د.ل؟`)) {
            po.status = action === 'Approve' ? 'Completed' : 'Rejected';
            alert('تم تحديث حالة التحويل بنجاح وسلس.');
            renderDashboard();
        }
    }

    function actionRefund(id, action) {
        let r = mockData.refunds.find(x => x.id === id);
        if (confirm(`هل تؤكد اعتماد إرجاع المبلغ (${r.amount} د.ل) لحساب العميل ${r.customer}؟`)) {
            r.status = 'Completed';
            alert('تمت معالجة الاسترداد وتحديث رصيد الخبير والمنصة تلقائياً.');
            renderDashboard();
        }
    }

    function closeModal() {
        document.getElementById('detailsModal').style.display = 'none';
    }

    function exportToCSV() {
        alert('جاري تحميل التقرير المالي الشامل بتنسيق CSV...');
    }

    // تهيئة الرسوم البيانية Chart.js
    window.onload = function() {
        renderDashboard();

        // Line Chart
        new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: {
                labels: ['15 أكتوبر', '18 أكتوبر', '20 أكتوبر', '22 أكتوبر', '24 أكتوبر', '26 أكتوبر'],
                datasets: [{
                    label: 'إجمالي المبيعات (Gross)',
                    data: [1200, 1500, 1800, 2400, 3100, 4225],
                    borderColor: '#0B192C',
                    fill: false
                }, {
                    label: 'صافي أرباح المنصة (Commission)',
                    data: [180, 225, 270, 360, 465, 633],
                    borderColor: '#059669',
                    fill: false
                }]
            }
        });

        // Doughnut Chart
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: ['ناجحة (Successful)', 'معلقة (Pending)', 'مستردة (Refunded)'],
                datasets: [{
                    data: [12, 1, 2],
                    backgroundColor: ['#16a34a', '#eab308', '#dc2626']
                }]
            }
        });
    };
</script>

<?php include '../includes/footer.php'; ?>