<?php
require_once 'config.php';
include 'includes/header.php';

$provider_id = 1;

// جلب المواعيد الخاصة بمقدم الخدمة من قاعدة البيانات
$query = "SELECT a.*, u.full_name AS customer_name 
          FROM appointments a 
          JOIN users u ON a.customer_id = u.id 
          WHERE a.provider_id = $provider_id 
          ORDER BY a.start_time DESC";
$result = mysqli_query($conn, $query);

$total_clients = 48;
$total_sessions = 342;
?>

<div style="max-width: 1200px; margin: 40px auto; padding: 0 20px; direction: rtl; text-align: right; font-family: inherit;">

    <!-- ترويسة وإحصائيات علوية -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
        <h1 style="font-size: 24px; font-weight: 700; color: #0f172a; margin: 0;">سجل المواعيد</h1>

        <div style="display: flex; gap: 16px; flex-wrap: wrap;">
            <!-- بطاقة إحصائية 1 -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px 24px; display: flex; align-items: center; gap: 16px; min-width: 220px;">
                <div style="width: 40px; height: 40px; background-color: #f1f5f9; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #0B192C;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <div>
                    <div style="font-size: 12px; color: #64748b;">إجمالي العملاء النشطون</div>
                    <div style="font-size: 18px; font-weight: 700; color: #0f172a;"><?php echo $total_clients; ?> عميلاً</div>
                </div>
            </div>

            <!-- بطاقة إحصائية 2 -->
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px 24px; display: flex; align-items: center; gap: 16px; min-width: 220px;">
                <div style="width: 40px; height: 40px; background-color: #f1f5f9; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #0B192C;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <div>
                    <div style="font-size: 12px; color: #64748b;">جلسات مكتملة مع العملاء</div>
                    <div style="font-size: 18px; font-weight: 700; color: #0f172a;"><?php echo $total_sessions; ?> جلسة</div>
                </div>
            </div>
        </div>
    </div>

    <!-- جدول مواعيد الجلسات الرئيسي -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
        <div style="margin-bottom: 20px;">
            <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin: 0 0 4px 0;">جدول مواعيد الجلسات</h3>
            <p style="font-size: 13px; color: #64748b; margin: 0;">سجل كامل ومفصل لجميع سجلاتك ومواعيدك</p>
        </div>

        <!-- التبويبات (Tabs) -->
        <div style="display: flex; background-color: #f1f5f9; border-radius: 10px; padding: 4px; margin-bottom: 24px; gap: 4px;">
            <div style="flex: 1; text-align: center; padding: 10px; font-size: 14px; font-weight: 600; color: #64748b; border-radius: 8px; cursor: pointer;">المواعيد المرفوضة</div>
            <div style="flex: 1; text-align: center; padding: 10px; font-size: 14px; font-weight: 600; color: #64748b; border-radius: 8px; cursor: pointer;">الطلبات القادمة</div>
            <div style="flex: 1; text-align: center; padding: 10px; font-size: 14px; font-weight: 600; color: #ffffff; background-color: #0B192C; border-radius: 8px; cursor: pointer;">سجل الجلسات والمواعيد (5)</div>
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
                        <th style="padding: 12px 16px; font-weight: 600; text-align: center;">الإجراء</th>
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
                                <td style="padding: 16px; font-weight: 700; color: #0f172a;"><?php echo number_format($price, 2); ?> د.ل</td>
                                <td style="padding: 16px; font-weight: 700; color: #ef4444;"><?php echo number_format($commission, 2); ?>- د.ل</td>
                                <td style="padding: 16px; font-weight: 700; color: #16a34a;"><?php echo number_format($net, 2); ?> د.ل</td>
                                <td style="padding: 16px; text-align: center;">
                                    <a href="#" style="background-color: #0B192C; color: #ffffff; padding: 8px 18px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600; display: inline-block;">بدء الجلسة</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <!-- بيانات تجريبية متوافقة تماماً مع اليمين لليسار (RTL) -->
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 16px; font-weight: 700; color: #0B192C;" dir="ltr">#CNS-91044</td>
                                <td style="padding: 16px; color: #0f172a; font-weight: 600;">سارة بنت خالد المنصور</td>
                                <td style="padding: 16px; color: #475569; font-size: 13px;">
                                    2025-05-15<br><span style="color: #64748b;">05:30 مساءً</span>
                                </td>
                                <td style="padding: 16px; font-weight: 700; color: #0f172a;">875.00 د.ل</td>
                                <td style="padding: 16px; font-weight: 700; color: #ef4444;">-75.00 د.ل</td>
                                <td style="padding: 16px; font-weight: 700; color: #16a34a;">800.00 د.ل</td>
                                <td style="padding: 16px; text-align: center;">
                                    <a href="#" style="background-color: #0B192C; color: #ffffff; padding: 8px 18px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600; display: inline-block;">بدء الجلسة</a>
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