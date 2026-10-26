<?php
require_once 'config.php';
include 'includes/header.php';

// جلب أبرز مقدمي الخدمات لعرضهم في الصفحة الرئيسية
$query = "SELECT p.*, u.full_name FROM provider_profiles p JOIN users u ON p.user_id = u.id LIMIT 3";
$result = mysqli_query($conn, $query);
?>

<div style="direction: rtl; text-align: right; font-family: inherit;">

  <!-- قسم الهيرو (Hero Section) -->
  <div style="background: linear-gradient(135deg, #0B192C 0%, #1e293b 100%); color: #ffffff; padding: 90px 20px; text-align: center; border-bottom: 1px solid #e2e8f0;">
    <div style="max-width: 800px; margin: 0 auto;">
      <span style="background-color: rgba(255, 255, 255, 0.1); color: #38bdf8; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; display: inline-block; margin-bottom: 20px;">منصة استشارات وتقنية المعلومات الموثوقة</span>
      <h1 style="font-size: 38px; font-weight: 800; margin: 0 0 20px 0; line-height: 1.4;">احصل على استشارات هندسية وتقنية احترافية بكل سهولة</h1>
      <p style="font-size: 16px; color: #94a3b8; margin: 0 0 32px 0; line-height: 1.6;">نربطك مباشرة بأبرز الخبراء والمطورين في مجال تقنية المعلومات، مع نظام حجز ذكي ودفع آمن عبر الكروت مسبقة الدفع.</p>
      <div>
        <a href="providers.php" style="background-color: #ffffff; color: #0B192C; padding: 14px 32px; border-radius: 10px; text-decoration: none; font-size: 15px; font-weight: 700; box-shadow: 0 4px 12px rgba(0,0,0,0.1); display: inline-block;">استعرض مقدمي الخدمات</a>
      </div>
    </div>
  </div>

  <!-- قسم من نحن (About Us) -->
  <div style="max-width: 1200px; margin: 70px auto; padding: 0 20px;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; align-items: center;">
      <div>
        <span style="color: #0b192c; font-size: 13px; font-weight: 700; background: #f1f5f9; padding: 6px 14px; border-radius: 8px; display: inline-block; margin-bottom: 12px;">من نحن</span>
        <h2 style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0 0 16px 0; line-height: 1.3;">نبني الجسور بين أصحاب المشاريع ونخبة الخبراء التقنيين</h2>
        <p style="font-size: 14px; color: #64748b; line-height: 1.8; margin: 0 0 16px 0;">نحن منصة رائدة متخصصة في توفير بيئة متكاملة لحجز الاستشارات التقنية وإدارة الخدمات البرمجية. نهدف إلى تمكين الشركات والأفراد من الوصول السريع إلى الكفاءات الموثوقة لتنفيذ مشاريعهم بكفاءة عالية وجودة استثنائية.</p>
      </div>
      <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 20px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
        <div style="display: flex; flex-direction: column; gap: 20px;">
          <div style="display: flex; align-items: center; gap: 14px;">
            <div style="width: 40px; height: 40px; background: #0B192C; color: #fff; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 700;">✓</div>
            <div>
              <h4 style="margin: 0 0 2px 0; font-size: 15px; color: #0f172a;">خبراء معتمدون</h4>
              <p style="margin: 0; font-size: 12px; color: #64748b;">نخبة من المطورين والمستشارين ذوي الخبرة العالية.</p>
            </div>
          </div>
          <div style="display: flex; align-items: center; gap: 14px;">
            <div style="width: 40px; height: 40px; background: #0B192C; color: #fff; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 700;">✓</div>
            <div>
              <h4 style="margin: 0 0 2px 0; font-size: 15px; color: #0f172a;">حجز مرن وآمن</h4>
              <p style="margin: 0; font-size: 12px; color: #64748b;">مواعيد دقيقة ونظام دفع موثوق بالكرت مسبق الدفع.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- قسم نوع الخدمات (Types of Services) - تنقل لصفحة مقدمي الخدمات -->
  <div style="background: #f8fafc; padding: 70px 20px; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0;">
    <div style="max-width: 1200px; margin: 0 auto;">
      <div style="text-align: center; margin-bottom: 40px;">
        <h2 style="font-size: 26px; font-weight: 700; color: #0f172a; margin: 0 0 8px 0;">مجالات الخدمات المتاحة</h2>
        <p style="font-size: 14px; color: #64748b; margin: 0;">اختر التخصص المطلوب لعرض قائمة الخبراء ومقدمي الخدمات المرتبطين به</p>
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px;">
        <!-- خدمة 1 -->
        <a href="providers.php?category=ui_ux" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; text-decoration: none; display: block; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: all 0.2s;">
          <div style="font-size: 28px; margin-bottom: 12px;">🎨</div>
          <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0 0 6px 0;">تصميم واجهات وتجربة المستخدم (UI/UX)</h3>
          <p style="font-size: 13px; color: #64748b; margin: 0 0 12px 0;">تصميم تطبيقات الموبايل والمنصات الرقمية وتحسين تجربة العملاء.</p>
          <span style="font-size: 13px; font-weight: 600; color: #0B192C;">تصفح المختصين ←</span>
        </a>

        <!-- خدمة 2 -->
        <a href="providers.php?category=web_dev" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; text-decoration: none; display: block; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: all 0.2s;">
          <div style="font-size: 28px; margin-bottom: 12px;">💻</div>
          <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0 0 6px 0;">تطوير الويب والمنصات الرقمية</h3>
          <p style="font-size: 13px; color: #64748b; margin: 0 0 12px 0;">بناء وبرمجة المواقع الإلكترونية والأنظمة السحابية المتقدمة.</p>
          <span style="font-size: 13px; font-weight: 600; color: #0B192C;">تصفح المختصين ←</span>
        </a>

        <!-- خدمة 3 -->
        <a href="providers.php?category=databases" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; text-decoration: none; display: block; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: all 0.2s;">
          <div style="font-size: 28px; margin-bottom: 12px;">🗄️</div>
          <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0 0 6px 0;">إدارة وهندسة قواعد البيانات</h3>
          <p style="font-size: 13px; color: #64748b; margin: 0 0 12px 0;">تصميم وتحسين أداء قواعد البيانات وضمان أمن واستقرار البيانات.</p>
          <span style="font-size: 13px; font-weight: 600; color: #0B192C;">تصفح المختصين ←</span>
        </a>

        <!-- خدمة 4 -->
        <a href="providers.php?category=it_consulting" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; text-decoration: none; display: block; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: all 0.2s;">
          <div style="font-size: 28px; margin-bottom: 12px;">💡</div>
          <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin: 0 0 6px 0;">الاستشارات التقنية الشاملة</h3>
          <p style="font-size: 13px; color: #64748b; margin: 0 0 12px 0;">استشارات هندسية وتقنية لدراسة وتقييم المشاريع البرمجية.</p>
          <span style="font-size: 13px; font-weight: 600; color: #0B192C;">تصفح المختصين ←</span>
        </a>
      </div>
    </div>
  </div>

  <!-- قسم لماذا تختارنا (Why Choosing Us) -->
  <div style="max-width: 1200px; margin: 70px auto; padding: 0 20px;">
    <div style="text-align: center; margin-bottom: 40px;">
      <h2 style="font-size: 26px; font-weight: 700; color: #0f172a; margin: 0 0 8px 0;">لماذا تختار منصتنا؟</h2>
      <p style="font-size: 14px; color: #64748b; margin: 0;">مميزات متكاملة لضمان أفضل تجربة استشارية تقنية</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px;">
      <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
        <div style="width: 48px; height: 48px; background: #f1f5f9; color: #0B192C; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; font-size: 22px;">⚡</div>
        <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin: 0 0 8px 0;">حجز فوري وذكي</h3>
        <p style="font-size: 13px; color: #64748b; line-height: 1.6; margin: 0;">اختر الموعد المناسب وتأكيد الجلسة مباشرة دون تعقيد، مع ربط كامل بالتقويم الذكي.</p>
      </div>

      <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
        <div style="width: 48px; height: 48px; background: #f1f5f9; color: #0B192C; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; font-size: 22px;">🔒</div>
        <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin: 0 0 8px 0;">دفع آمن بالكرت مسبق الدفع</h3>
        <p style="font-size: 13px; color: #64748b; line-height: 1.6; margin: 0;">نظام سداد موثوق عبر إدخال رموز الكروت مسبقة الدفع بكل أمان وسلاسة.</p>
      </div>

      <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
        <div style="width: 48px; height: 48px; background: #f1f5f9; color: #0B192C; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; font-size: 22px;">📊</div>
        <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin: 0 0 8px 0;">لوحة تحكم احترافية</h3>
        <p style="font-size: 13px; color: #64748b; line-height: 1.6; margin: 0;">إدارة شاملة للمواعيد، أوقات التوفر، والمعاملات المالية مع حساب دقيق لعمولات المنصة.</p>
      </div>
    </div>
  </div>

  <!-- قسم أبرز مقدمي الخدمات -->
  <div style="background: #f8fafc; padding: 70px 20px; border-top: 1px solid #e2e8f0;">
    <div style="max-width: 1200px; margin: 0 auto;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; flex-wrap: wrap; gap: 16px;">
        <div>
          <h2 style="font-size: 24px; font-weight: 700; color: #0f172a; margin: 0 0 4px 0;">نخبة الخبراء والمستشارين</h2>
          <p style="font-size: 13px; color: #64748b; margin: 0;">احجز استشارتك الآن مع أفضل المتخصصين التقنيين</p>
        </div>
        <a href="providers.php" style="color: #0B192C; font-size: 14px; font-weight: 700; text-decoration: none;">عرض الجميع ←</a>
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px;">
        <?php if ($result && mysqli_num_rows($result) > 0): ?>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); display: flex; flex-direction: column; justify-content: space-between;">
              <div>
                <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 16px;">
                  <div style="width: 50px; height: 50px; background: #0B192C; color: #ffffff; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 18px;">
                    <?php echo mb_substr($row['full_name'], 0, 1); ?>
                  </div>
                  <div>
                    <h3 style="margin: 0 0 4px 0; font-size: 16px; font-weight: 700; color: #0f172a;"><?php echo htmlspecialchars($row['full_name']); ?></h3>
                    <p style="margin: 0; font-size: 12px; color: #64748b;"><?php echo htmlspecialchars($row['specialization'] ?? 'استشاري تقني'); ?></p>
                  </div>
                </div>
                <p style="font-size: 13px; color: #475569; line-height: 1.6; margin: 0 0 20px 0;"><?php echo htmlspecialchars(mb_substr($row['bio'] ?? 'خبرة واسعة في تقديم الاستشارات التقنية وحلول تطوير البرمجيات والأنظمة السحابية.', 0, 90)); ?>...</p>
              </div>
              <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 16px; margin-top: 16px;">
                <span style="font-size: 15px; font-weight: 700; color: #0B192C;"><?php echo number_format($row['consultation_price'] ?? 250, 2); ?> د.ل / جلسة</span>
                <a href="view_provider.php?id=<?php echo $row['id']; ?>" style="background-color: #0B192C; color: #ffffff; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600;">حجز موعد</a>
              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p style="color: #64748b; text-align: center; grid-column: 1 / -1;">لا يوجد مقدمي خدمات متاحين حالياً.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

</div>

<?php include 'includes/footer.php'; ?>