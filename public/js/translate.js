angular.module('App')
    .config(['$translateProvider', function ($translateProvider) {
        $translateProvider.translations('Eng', {
            'KEY_LOGIN_REGISTER':  'Login / Join us',
            'KEY_NOTIFICATION':  'Notification',
            'KEY_DASHBOARD':  'Dashboard',
            'KEY_LANGUAGES':  'Languages',
            'KEY_HOME':       'Home',
            'KEY_REGISTER':   'Register',
            'KEY_LOGIN':      'Log in',
            'KEY_LOGOUT':     'Log out',
            'KEY_FOLLOW':     'Follow',
            'KEY_FOLLOWER':   'Follower',
            'KEY_UNFOLLOW':   'Unfollow',
            'KEY_FOLLOWING':  'Following',
            'KEY_POST':       'Post',
            'KEY_POSTED':     'Posted',
            'KEY_UPVOTE':     'Upvote',
            'KEY_UPVOTED':    'Upvoted',
            'KEY_DWN_VOTE':   'Downvote',
            'KEY_DWN_VOTED':  'Downvoted',
            'KEY_VIEW':       'View',
            'KEY_REMOVE':     'Remove',
            'KEY_CANCEL':     'Cancel',
            'KEY_QUESTION':   'Question',
            'KEY_TOPIC':      'Topic',
            'KEY_STORY':      'Story',
            'KEY_CHG_PWD':    'Reset Password',
            'KEY_PASSWORD':   'Password',
            'KEY_OLD_PWD':    'Old Password',
            'KEY_NEW_PWD':    'New Password',
            'KEY_NEW_PWD_C':  'Confirm password',
            'KEY_SAVE':       'Save',
            'KEY_SAVE_DRAFT': 'Save as draft',
            'KEY_TAGS':       'Tags',
            'KEY_EXPLORE':    'Explore',
            'KEY_CHECK':      'Check',
            'KEY_FEAT_CAT':   'Features categories',
            'KEY_COMMENTS':   'Comments',
            'KEY_REPLY':      'Reply',
            'KEY_PHOTO':      'Photo',
            'KEY_REVIEW':     'Review',
            'KEY_REVIEW_NAME':'Name of the product/service review',
            'KEY_EDIT':       'Edit',
            'KEY_EDITED':     'Edited',
            'KEY_TREND':      'Trend',
            'KEY_TRENDING':   'Trending',
            'KEY_BOOKMARK':   'Bookmark',
            'KEY_MST_REC':    'Most recomended',
            'KEY_ADD_FIELD':  'Add field',
            'KEY_LOGIN_FB':   'Login with Facebook',
            'KEY_NO_ANSWER':  'No answer, yet',

            'KEY_HISTORY':    'History',
            'KEY_WRITE_REPLY':'Write a reply',
            'KEY_LATEST_FEED':'Latest Feed',
            'KEY_IN':         'in',
            'KEY_BY':         'by',

            //Remove topic
            'KEY_CONF_REMOVE':'Are you sure you want to remove?',
            'KEY_CONF_REM_C': 'Once remove, you will not be ableto to get this topic back',


            //SENTENCE
            'KEY_WHAT_ON_UR_MIND':  'What\'s on your mind?',
            'KEY_YOU_WANT_FOLLOW':  'You may want to follow',
            'KEY_NO_ACCT_REGISTER': 'Don\'t have account? Join us',
            'KEY_CREATE_ACCT':      'Create account',
            'KEY_CANT_CHNG_USER':   'Don\'t have account? Register',
            'KEY_YOUR_ACCOUNT':     'Your account',
            'KEY_NOTHING_HERE':     'Nothing here, yet',
            'KEY_WHO_TO_FOLLOW':    'Who to follow',
            'KEY_CAT_WILL_APPEAR':  'Follow some categories and it will appear here',
            'KEY_WHT_UR_STORY':     'What\'s your story',
            'KEY_WRT_COMMENT':      'Write a response',
            'KEY_FORGOT_PWD':       'Forgot Your Password?',
            'KEY_UPLOAD_PHOTO':     'Upload photo',
            'KEY_TAGS_FOLLOW':      'Tags you are following',
            'KEY_NAME_CHG_ONCE':    'Warning! You can only change displayname once',
            'KEY_SEL_CHN':          'Select channel',
            'KEY_IT_IS_ABOUT':      'This is about...',
            'KEY_PWD_RESET':        'Send Password Reset Link',
            'KEY_WRITE_SOMETHING':  'Write something ( you can also copy + paste here)',
            'KEY_CODE_SENT':        'Code sent, check your email',

            //VERIFICATION CODE
            'KEY_V_SIGN_UP':        'Thanks for Sign up with Qanya!. Please activate your account by enter the code in the box.',
            'KEY_CFM_CODE':         'Confirmation Code',
            'KEY_CODE_INC':         'the code is incorrect',
            'KEY_CFM':              'Confirmation',
            'KEY_RESEND_CODE':      'Resend code',

            //USER RATING
            'KEY_USER_RATING':  'User Rating',
            'KEY_DETAILS':      'Details',

            //USER INPUT
            'KEY_FIRSTNAME':  'First name',
            'KEY_LASTNAME':   'Last name',
            'KEY_BIRTHDAY':   'Birthday',
            'KEY_MONTH':      'Month',
            'KEY_DAY':        'Day',
            'KEY_EMAIL':      'Email',
            'KEY_CONF_EMAIL': 'Confirm Email',
            'KEY_GENDER':     'Gender',
            'KEY_MALE':       'Male',
            'KEY_FEMALE':     'Female',
            'KEY_USERNAME':   'Username',
            'KEY_LOCATION':   'Location',
            'KEY_REMEMBER_ME':'Remember me',

            //User Edit
            'KEY_ED_PROFILE': 'Edit Profile',
            'KEY_ED_CHG_PWD': 'Change Password',
            'KEY_ED_PROFILE': 'Edit Profile',
            'KEY_ED_SITE':    'Website',
            'KEY_ED_PHONE':   'Phone',
            'KEY_ED_BIO':     'Biography',


        });


        //THAI TRANSLATIOn
        $translateProvider.translations('ไทย', {
            'KEY_LOGIN_REGISTER':  'เข้าใช้ / สมัครใช้',
            'KEY_NOTIFICATION':  'Notification',
            'KEY_DASHBOARD':  'ห้องทั้งหมด',
            'KEY_LANGUAGES':  'ภาษา',
            'KEY_HOME':       'หน้าแรก',
            'KEY_REGISTER':   'สมัครใช้',
            'KEY_LOGIN':      'เข้าใช้',
            'KEY_LOGOUT':     'ออกจากระบบ',
            'KEY_FOLLOW':     'ติดตาม',
            'KEY_FOLLOWER':   'ผู้ติดตาม',
            'KEY_UNFOLLOW':   'เลิกติดตาม',
            'KEY_FOLLOWING':  'กำลังติดตาม',
            'KEY_POST':       'โพสต์',
            'KEY_POSTED':     'โพสต์',
            'KEY_UPVOTE':     'อัฟโหวต',
            'KEY_UPVOTED':    'อัฟโหวต',
            'KEY_DWN_VOTE':   'ดาวน์โหวต',
            'KEY_DWN_VOTED':  'ดาวน์โหวต',
            'KEY_VIEW':       'ผู้ชม',
            'KEY_REMOVE':     'ลบ',
            'KEY_CANCEL':     'ยกเลิก',
            'KEY_QUESTION':   'ตั้งคำถาม',
            'KEY_TOPIC':      'หัวข้อ',
            'KEY_STORY':      'เรื่องราว',
            'KEY_CHG_PWD':    'เปลี่ยนรหัสผ่าน',
            'KEY_PASSWORD':   'รหัสผ่าน',
            'KEY_OLD_PWD':    'รหัสผ่านเก่า',
            'KEY_NEW_PWD':    'รหัสผ่านใหม่',
            'KEY_NEW_PWD_C':  'ยืนยันรหัสผ่าน',
            'KEY_SAVE':       'บันทึก',
            'KEY_SAVE_DRAFT': 'บันทึกเก็บไว้ก่อน',
            'KEY_TAGS':       'แท็ก',
            'KEY_EXPLORE':    'Explore',
            'KEY_CHECK':      'ตรวจสอบ',
            'KEY_FEAT_CAT':   'Features categories',
            'KEY_COMMENTS':   'ความเห็น',
            'KEY_REPLY':      'ตอบ',
            'KEY_PHOTO':      'รูป',
            'KEY_REVIEW':     'รีวิว',
            'KEY_REVIEW_NAME':'ชื่อของสิ่งที่รีวิว',
            'KEY_EDIT':       'แก้ไข',
            'KEY_EDITED':     'ถูกแก้ไข',
            'KEY_TREND':      'เทรนด์',
            'KEY_TRENDING':   'กำลังนิยม',
            'KEY_BOOKMARK':   'บุคมาร์ค',
            'KEY_MST_REC':    'แนะนำมากสุด',
            'KEY_ADD_FIELD':  'เพิ่ม',
            'KEY_LOGIN_FB':   'เข้าใช้ด้วย Facebook ',
            'KEY_NO_ANSWER':  'ยังไม่มีคำตอบ',
            'KEY_MSTVIEW_TDAY':'คำถามที่มีผู้ชมเยอะ',
            'KEY_WNT_TO_KNOW':'อยากรู้คำตอบ',
            'KEY_ADD_DETAILS':'เพิ่มรายละเอียด',

            'KEY_HISTORY':    'ประวัติการเข้าชม',
            'KEY_WRITE_REPLY':'เขียนตอบ',
            'KEY_LATEST_FEED':'ฟีดล่าสุด',
            'KEY_IN':         'ใน',
            'KEY_BY':         'โดย',

            //Remove topic
            'KEY_CONF_REMOVE':'คุณแน่ใจหรือว่าต้องการลบ?',
            'KEY_CONF_REM_C': 'เมื่อลบออกคุณจะไม่สามารถที่จะนำหัวข้อนี้กลับมา',

            //SENTENCE
            'KEY_WHAT_ON_UR_MIND':  'คุณกำลังคิดอะไรอยู่?',
            'KEY_YOU_WANT_FOLLOW':  'คุณอาจจะอยากติดตาม',
            'KEY_NO_ACCT_REGISTER': 'อยากเข้าใช้? มาทางนี้เลย',
            'KEY_CREATE_ACCT':      'สร้างบัญชี',
            'KEY_CANT_CHNG_USER':   'ไม่มีบัญชี? สมัครสมาชิก',
            'KEY_YOUR_ACCOUNT':     'บัญชีของคุณ',
            'KEY_NOTHING_HERE':     'ยังไม่มีอะไรที่นี่ตอนนี้',
            'KEY_WHO_TO_FOLLOW':    'ติดตามใครดี',
            'KEY_CAT_WILL_APPEAR':  'Follow some categories and it will appear here',
            'KEY_WHT_UR_STORY':     'What\'s your story',
            'KEY_WRT_COMMENT':      'เขียนความคิดเห็น',
            'KEY_FORGOT_PWD':       'ลืมรหัสผ่าน?',
            'KEY_UPLOAD_PHOTO':     'เปลี่ยนรูป',
            'KEY_TAGS_FOLLOW':      'แท็กที่คุณกำลังติดตาม',
            'KEY_NAME_CHG_ONCE':    'คำเตือน! คุณสามารถเปลี่ยนชื่อผู้ใช้ได้ครั้งเดียว',
            'KEY_SEL_CHN':          'เลือกช่อง',
            'KEY_IT_IS_ABOUT':      'เขียนเกี่ยวกับ...',
            'KEY_PWD_RESET':        'ส่งลิงค์การเปลี่ยนรหัสผ่าน',
            'KEY_WRITE_SOMETHING':  'เริ่มเขียนเลย (สามารถ copy + paste ใส่ในนี้ได้)',
            'KEY_CODE_SENT':        'ส่งโค๊ดไปแล้วทางอีเมล์',


            //VERIFICATION CODE
            'KEY_V_SIGN_UP':        'ขอบคุณที่สมัครใช้งานกับ Qanya กรุณาใส่รหัสผ่านที่เราส่งให้ไปทางอีเมล์ในช่องด้านล่าง',
            'KEY_CFM_CODE':         'รหัสผ่าน',
            'KEY_CODE_INC':         'รหัสไม่ถูกต้อง',
            'KEY_CFM':              'ยืนยันรหัส',
            'KEY_RESEND_CODE':      'ส่งรหัสอีกครั้ง',

            //USER RATING
            'KEY_USER_RATING':  'คะแนนของผู้รีวิว',
            'KEY_DETAILS':      'รายละเอียด',

            //USER INPUT
            'KEY_FIRSTNAME':  'ชื่อจริง',
            'KEY_LASTNAME':   'นามสกุล',
            'KEY_BIRTHDAY':   'Birthday',
            'KEY_MONTH':      'Month',
            'KEY_DAY':        'Day',
            'KEY_EMAIL':      'อีเมล์',
            'KEY_CONF_EMAIL': 'ยืนยันอีเมล์',
            'KEY_GENDER':     'เพศ',
            'KEY_MALE':       'ชาย',
            'KEY_FEMALE':     'หญิง',
            'KEY_USERNAME':   'ชื่อผู้ใช้',
            'KEY_LOCATION':   'สถานที่',
            'KEY_REMEMBER_ME':'จดจำฉัน',

            //User Edit
            'KEY_ED_PROFILE': 'แก้ไขโปรไฟล์',
            'KEY_ED_CHG_PWD': 'เปลี่ยนรหัสผ่าน',
            'KEY_ED_SITE':    'เว็บไซต์',
            'KEY_ED_PHONE':   'โทรศัพท์',
            'KEY_ED_BIO':     'ชีวประวัติ',

        });

        $translateProvider.preferredLanguage('ไทย');
    }])