<?php
require_once 'config.php';
include 'includes/header.php';

$provider_id = 1;

// جلب المعاملات المالية الخاصة بمقدم الخدمة من قاعدة البيانات
$query = "SELECT a.*, u.full_name AS customer_name, p.amount, p.payment_status 
          FROM appointments a 
          JOIN users u ON a.customer_id = u.id 
          LEFT JOIN payments p ON a.id = p.appointment_id 
          WHERE a.provider_id = $provider_id 
          ORDER BY a.start_time DESC";
$result = mysqli_query($conn, $query);

$total_earnings = "2500.00";
$available_balance = "2500.00";
?>

<div style="max-width: 1200px; margin: 40px auto; padding: 0 20px; direction: rtl; text-align: right; font-family: inherit;">

    <!-- ترويسة الصفحة وبطاقات المحفظة الرقمية العلوية -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <h1 style="font-size: 24px; font-weight: 700; color: #0f172a; margin: 0;">المحفظة الرقمية وسجل الأرباح المالية</h1>

        <div style="display: flex; gap: 16px; flex-wrap: wrap;">
            <!-- بطاقة إحصائية 1: إجمالي الأرباح المحققة -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px 24px; display: flex; align-items: center; gap: 16px; min-width: 240px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                <div style="width: 44px; height: 44px; background-color: #f1f5f9; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #059669;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                        <line x1="2" y1="10" x2="22" y2="10"></line>
                    </svg>
                </div>
                <div>
                    <div style="font-size: 12px; color: #64748b; margin-bottom: 4px;">إجمالي الأرباح المحققة (2026)</div>
                    <div style="font-size: 20px; font-weight: 700; color: #0f172a; direction: ltr; text-align: right;"><?php echo $total_earnings; ?>د.ل</div>
                </div>
            </div>

            <!-- بطاقة إحصائية 2: الرصيد المتاح للسحب الفوري -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px 24px; display: flex; align-items: center; gap: 16px; min-width: 240px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                <div style="width: 44px; height: 44px; background-color: #f1f5f9; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #059669;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                        <line x1="2" y1="10" x2="22" y2="10"></line>
                    </svg>
                </div>
                <div>
                    <div style="font-size: 12px; color: #64748b; margin-bottom: 4px;">الرصيد المتاح للسحب الفوري</div>
                    <div style="font-size: 20px; font-weight: 700; color: #0f172a; direction: ltr; text-align: right;"><?php echo $available_balance; ?>د.ل</div>
                </div>
            </div>
        </div>
    </div>

    <!-- جدول المعاملات وحركات المحفظة المالية -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
        <div style="margin-bottom: 20px;">
            <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin: 0 0 4px 0;">جدول المعاملات وحركات المحفظة المالية</h3>
            <p style="font-size: 13px; color: #64748b; margin: 0;">سجل كامل ومفصل لجميع عوائد الاستشارات، تحويلات الحساب، والفواتير الضريبية</p>
        </div>

        <!-- التبويبات (Tabs) -->
        <div style="display: flex; background-color: #f1f5f9; border-radius: 10px; padding: 4px; margin-bottom: 24px; gap: 4px;">
            <div style="flex: 1; text-align: center; padding: 10px; font-size: 14px; font-weight: 600; color: #64748b; border-radius: 8px; cursor: pointer;">الكشف</div>
            <div style="flex: 1; text-align: center; padding: 10px; font-size: 14px; font-weight: 600; color: #64748b; border-radius: 8px; cursor: pointer;">سحوبات الحساب</div>
            <div style="flex: 1; text-align: center; padding: 10px; font-size: 14px; font-weight: 600; color: #ffffff; background-color: #0B192C; border-radius: 8px; cursor: pointer;">كافة المعاملات المالية</div>
        </div>

        <!-- الجدول -->
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; text-align: right; font-size: 14px;">
                <thead>
                    <tr style="border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 13px;">
                        <th style="padding: 12px 16px; font-weight: 600; text-align: right;">المعاملة / الجلسة</th>
                        <th style="padding: 12px 16px; font-weight: 600; text-align: right;">اسم المستفيد</th>
                        <th style="padding: 12px 16px; font-weight: 600; text-align: right;">التاريخ والوقت</th>
                        <th style="padding: 12px 16px; font-weight: 600; text-align: right;">المبلغ الإجمالي</th>
                        <th style="padding: 12px 16px; font-weight: 600; text-align: right;">عمولة المنصة (10%)</th>
                        <th style="padding: 12px 16px; font-weight: 600; text-align: right;">صافي المستحق</th>
                        <th style="padding: 12px 16px; font-weight: 600; text-align: center;">حالة الحركة</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)):
                            $price = $row['consultation_price'];
                            $commission = $price * 0.10;
                            $net = $price - $commission;
                            $aptCode = "#APT" . (1300 + $row['id']);
                        ?>
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 16px; font-weight: 700; color: #0B192C;" dir="ltr"><?php echo $aptCode; ?></td>
                                <td style="padding: 16px; color: #0f172a; font-weight: 600;"><?php echo htmlspecialchars($row['customer_name']); ?></td>
                                <td style="padding: 16px; color: #475569; font-size: 13px;">
                                    <?php echo date('Y-m-d', strtotime($row['start_time'])); ?><br>
                                    <span style="color: #64748b;"><?php echo date('h:i A', strtotime($row['start_time'])); ?></span>
                                </td>
                                <td style="padding: 16px; font-weight: 700; color: #0f172a;" dir="ltr"><?php echo number_format($price, 2); ?>د.ل</td>
                                <td style="padding: 16px; font-weight: 700; color: #ef4444;" dir="ltr">-<?php echo number_format($commission, 2); ?>د.ل</td>
                                <td style="padding: 16px; font-weight: 700; color: #16a34a;" dir="ltr"><?php echo number_format($net, 2); ?>د.ل</td>
                                <td style="padding: 16px; text-align: center;">
                                    <span style="background-color: #dcfce7; color: #16a34a; padding: 6px 16px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-block;">مكتملة</span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <!-- بيانات تجريبية مطابقة للصورة بدقة تامة -->
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 16px; font-weight: 700; color: #0B192C;" dir="ltr">#CNS-91044</td>
                                <td style="padding: 16px; color: #0f172a; font-weight: 600;">سارة بنت خالد المنصور</td>
                                <td style="padding: 16px; color: #475569; font-size: 13px;">
                                    15 مايو 2025<br><span style="color: #64748b;">04:30 مساءً</span>
                                </td>
                                <td style="padding: 16px; font-weight: 700; color: #0f172a;" dir="ltr">875.00د.ل</td>
                                <td style="padding: 16px; font-weight: 700; color: #ef4444;" dir="ltr">-75.00د.ل</td>
                                <td style="padding: 16px; font-weight: 700; color: #16a34a;" dir="ltr">800.00د.ل</td>
                                <td style="padding: 16px; text-align: center;">
                                    <span style="background-color: #dcfce7; color: #16a34a; padding: 6px 16px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-block;">مكتملة</span>
                                </td>
                            </tr>
                        <?php endfor; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>