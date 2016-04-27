	$(document).ready
	(
		function ()
		{
			$('.logpage_form').css('display', 'none');
			$('#'+s_form).css('display', 'block');

			$('#log_remeberme').click(
				function()
				{
					if( $('#log_remeberme').attr('checked'))
					{
						remember =true;
					}
					else
					{
						remember =false;
					}
				}
			);

			$('#log_forgot').click(
				function()
				{
					$('#log_form').css('display', 'none');
					$('#recover_form').css('display', 'block');
					return false;
				}
			);

			$('#recover_log').click(
				function()
				{
					$('#recover_form').css('display', 'none');
					$('#log_form').css('display', 'block');
					return false;
				}
			);

			$('#log_form').submit( 
				function () 
				{
					if ( $.trim($('#log_name').val()) =='' || $.trim($('#log_pass').val()) =='')
					{
						alert('Please fill all fields');
						return false;
					}

					if (!remember)
					{
						$('#log_m_pass').val(hex_md5($.trim($('#log_pass').val())));
						if (readCookie("rem") != null ) { eraseCookie('rem'); }
					}
					else
					{
						if($('#log_pass').val() != '|||')
						{
							userb = hex_md5($.trim($('#log_pass').val()));
						}
						$('#log_m_pass').val(userb);
						createCookie('rem', Base64.encode($.trim($('#log_name').val()) + '|||' + userb) ,360);
					}
					return true;
				}
			);

			$('#recover_form').submit( 
				function () 
				{
					if ( $.trim($('#recover_mail').val()) =='' )
					{
						alert('Please fill all fields');
						return false;
					}
					return true;
				}
			);

		}
	);