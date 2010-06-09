{include:file='{$BACKEND_CORE_PATH}/layout/templates/header.tpl'}
{include:file='{$BACKEND_CORE_PATH}/layout/templates/sidebar.tpl'}
	<td id="contentHolder">
			<div class="inner">

				<div class="pageTitle">
					<h2>{$lblUsers|ucfirst}: {$msgEditWithItem|sprintf:{$record['username']}}</h2>
				</div>

				{form:edit}
					<table class="settingsUserInfo" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td>
								<div class="avatar av48">
									{option:record['settings']['avatar']}
										<img src="{$FRONTEND_FILES_URL}/backend_users/avatars/64x64/{$record['settings']['avatar']}" width="48" height="48" alt="" />
									{/option:record['settings']['avatar']}
								</div>
							</td>
							<td>
								<table class="infoGrid" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<th>{$lblName|ucfirst}:</th>
										<td><strong>{$record['settings']['name']} {$record['settings']['surname']}</strong></td>
									</tr>
									<tr>
										<th>{$lblNickname|ucfirst}:</th>
										<td>{$record['settings']['nickname']}</td>
									</tr>
									<tr>
										<th>{$lblEmail|ucfirst}:</th>
										<td>{$record['settings']['email']}</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>

					<div id="tabs" class="tabs">
						<ul>
							<li><a href="#tabSettings">{$lblSettings|ucfirst}</a></li>
							<li><a href="#tabPassword">{$lblPassword|ucfirst}</a></li>
							<li><a href="#tabPermissions">{$lblPermissions|ucfirst}</a></li>
						</ul>

						<div id="tabSettings">
							<div class="subtleBox">
								<div class="heading">
									<h3>{$lblCredentials|ucfirst}</h3>
								</div>
								<div class="options horizontal labelWidthLong">
									<p>
										<label for="username">{$lblUsername|ucfirst}</label>
										{$txtUsername} {$txtUsernameError}
									</p>
								</div>
							</div>

							<div class="subtleBox">
								<div class="heading">
									<h3>{$lblPersonalInformation|ucfirst}</h3>
								</div>
								<div class="options horizontal labelWidthLong">
									<p>
										<label for="name">{$lblName|ucfirst}</label>
										{$txtName} {$txtNameError}
									</p>
									<p>
										<label for="surname">{$lblSurname|ucfirst}</label>
										{$txtSurname} {$txtSurnameError}
									</p>
									<p>
										<label for="email">{$lblEmail|ucfirst}</label>
										{$txtEmail} {$txtEmailError}
									</p>
									<p>
										<label for="nickname">{$lblNickname|ucfirst}</label>
										{$txtNickname} {$txtNicknameError}
										<span class="helpTxt">{$msgHelpNickname}</span>
									</p>
									<p>
										<label for="avatar">{$lblAvatar|ucfirst}</label>
										{$fileAvatar} {$fileAvatarError}
										<span class="helpTxt">{$msgHelpAvatar}</span>
									</p>
								</div>
							</div>

							<div class="subtleBox">
								<div class="heading">
									<h3>{$lblInterfacePreferences|ucfirst}</h3>
								</div>
								<div class="options horizontal labelWidthLong">
									<p>
										<label for="interfaceLanguage">{$lblInterfaceLanguage|ucfirst}</label>
										{$ddmInterfaceLanguage} {$ddmInterfaceLanguageError}
									</p>
									<p>
										<label for="date_format">{$lblDateFormat|ucfirst}</label>
										{$ddmDateFormat} {$ddmDateFormatError}
									</p>
									<p>
										<label for="time_format">{$lblTimeFormat|ucfirst}</label>
										{$ddmTimeFormat} {$ddmTimeFormatError}
									</p>
								</div>
							</div>
						</div>

						<div id="tabPassword">

							<div class="subtleBox">

								<div class="heading">
									<h3>{$lblChangePassword|ucfirst}</h3>
								</div>
								<div class="options horizontal labelWidthLong">
									<p>
										<label for="newPassword">{$lblPassword|ucfirst}</label>
										{$txtNewPassword} {$txtNewPasswordError}

										<table id="passwordStrengthMeter" class="passwordStrength" rel="newPassword" cellspacing="0">
											<tr>
												<td class="strength" id="passwordStrength">
													<p class="strength none">/</p>
													<p class="strength weak" style="background: red;">{$lblWeak|ucfirst}</p>
													<p class="strength ok" style="background: orange;">{$lblOK|ucfirst}</p>
													<p class="strength strong" style="background: green;">{$lblStrong|ucfirst}</p>
												</td>
												<td>
													<p class="helpTxt">{$msgHelpStrongPassword}</p>
												</td>
											</tr>
										</table>
									</p>
									<p>
										<label for="confirmPassword">{$lblConfirmPassword|ucfirst}</label>
										{$txtConfirmPassword} {$txtConfirmPasswordError}
									</p>
								</div>
							</div>

						</div>

						<div id="tabPermissions">
							<div class="subtleBox">
								<div class="heading">
									<h3>{$lblAccountManagement|ucfirst}</h3>
								</div>

								<div class="options">
									<ul class="inputList">
										<li>
											{$chkActive}
											<label for="active">{$msgEnableUser}</label>
											 {$chkActiveError}
										</li>
									</ul>

									<p>
										<label for="group">{$lblGroup|ucfirst}</label>
										{$ddmGroup} {$ddmGroupError}
									</p>
								</div>
							</div>

						</div>
					</div>

					<div class="fullwidthOptions">
						{option:deleteAllowed}
						<a href="{$var|geturl:'delete'}&id={$record['id']}" rel="confirmDelete" class="askConfirmation button linkButton icon iconDelete">
							<span>{$lblDelete|ucfirst}</span>
						</a>
						{/option:deleteAllowed}

						<div class="buttonHolderRight">
							<input id="edit" class="inputButton button mainButton" type="submit" name="edit" value="{$lblEdit|ucfirst}" />
						</div>
					</div>

					<div id="confirmDelete" title="{$lblDelete|ucfirst}?" style="display: none;">
						<p>
							{$msgConfirmDelete|sprintf:{$record['settings']['nickname']}}
						</p>
					</div>
				{/form:edit}
			</div>
		</td>
	</tr>
</table>
{include:file='{$BACKEND_CORE_PATH}/layout/templates/footer.tpl'}