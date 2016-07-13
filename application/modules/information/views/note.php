<!-- Page Content -->
<div class="container<?php echo isset($fluid)? '-fluid' : '' ?>">

    <!-- Content Section -->
    <div class="row mt35">
        <div class="col-lg-12">
            <h3 class="page-header text-green no-padding-b">
                活動注意事項
            </h3>
            <ol class="notice-text">&nbsp;
                <li>本活動僅限臺灣發行之中國信託VISA/MasterCard/JCB信用卡正卡持卡人參加。</li>
                <li>須透過中國信託食友網站 <a href="http://www.fooriends.com" target="_blank">www.fooriends.com</a> 進行報名，並使用中國信託信用卡線上刷卡完成付款，方得參與本活動。</li>
                <li>本優惠係由定贏傳媒股份有限公司維護的中國信託食友網站主辦，持卡人透過中國信託食友網站報名參加活動時，即代表您已審閱並同意中國信託食友網站«活動注意事項»、«個人資料保護說明»及活動相關資訊。請您確實核對訂單內容再前往結帳付款，訂單成立後表示您同意訂單內容及金額，不得以任何理由拒付費用。</li>
                <li>活動報名人數皆有限額，若遇報名額滿，恕無法提供優惠。若因故須取消報名，請於活動前10個工作日（不包含課程當天）告知，撥打中國信託食友網站客服電話(02)7702-1168#63林小姐(週一至週五09:30-18:30)尋求協助，依來電或來信時間為基準，可全額退費或保留費用，若遇休假日則以留言時間為準。逾時恕無法受理取消報名，定贏傳媒股份有限公司將於資料核對無誤後進行退款。若在10個工作日內（不包含課程當天）取消者，將不予退費、換課，但可由親友代為上課。</li>
                <li>本活動之商品或服務係由合作餐廳提供，中國信託僅提供各項優惠訊息，並非商品或服務之出售人，與參與餐廳之間並無代理或提供訂位等其他保證，持卡人對於提供服務內容有任何爭議，請逕洽定贏傳媒股份有限公司尋求協助，客服電話(02)7702-1168#63林小姐(週一至週五09:30-18:30)。</li>
                <li>本活動可選擇索取二聯式或三聯式紙本發票，請提供真實姓名與行動電話號碼，發票將於活動當天提供。</li>
                <li>更多「中國信託食友」優惠訊息、精選餐廳明細、相關權益或服務細節與限制條件，請上中國信託食友網站 <a href="http://www.fooriends.com.tw" target="_blank">www.fooriends.com</a> 查詢。</li>
            </ol>
        </div>   
    </div>
    <!-- /.row -->
    <!-- Bank Note Section -->
    <?php ( ! isset($fluid) )? $this->load->view('front/bank_note')  : '' ?>
    <!-- /.row -->
</div>
<!-- /.container  -->