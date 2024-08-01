<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription et Connexion</title>
    <link rel="stylesheet" href="PageConnexion.css">
</head>
<body>
    <div class="background-image"></div>

    <header class="header">
        <div class="header-content">
            <div class="logo">
                <img src="image/LOGO-3_2.png" alt="Logo de MAYAR">
            </div>
            <button class="menu-button" onclick="toggleMenu()">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </button>
        </div>
    </header>
    <nav class="menu">
        <a href="index.html">Accueil</a>
        <a href="#" onclick="toggleForm('login')">Connexion</a>
        <a href="#" onclick="toggleForm('signup')">Inscription</a>
        <a href="#">Devenir Hôte</a>
        <div class="separator"></div>
        <a href="#">Support</a>
    </nav>

    <div class="container" id="container">
        <div class="form-container sign-up">
            <form id="signup-form">
                <h1>Créer un compte</h1>
                <div class="name-container">
                    <input type="text" name="name" placeholder="Nom" required>
                    <input type="text" name="prenom" placeholder="Prénom" required>
                </div>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Mot de passe" required>
                <div class="date-container">
                    <label for="date-naissance" id="date-label">Date de naissance :</label>
                    <input type="date" name="birthdate" id="date-naissance" required>
                </div>
                <div class="phone-container">
                    <select name="country_code" required>
                        <option value="" disabled selected>Indicatif</option>
                        <option value="+1">+1 (USA, Canada)</option>
                        <option value="+7">+7 (Russia)</option>
                        <option value="+20">+20 (Egypt)</option>
                        <option value="+27">+27 (South Africa)</option>
                        <option value="+30">+30 (Greece)</option>
                        <option value="+31">+31 (Netherlands)</option>
                        <option value="+32">+32 (Belgium)</option>
                        <option value="+33">+33 (France)</option>
                        <option value="+34">+34 (Spain)</option>
                        <option value="+36">+36 (Hungary)</option>
                        <option value="+39">+39 (Italy)</option>
                        <option value="+40">+40 (Romania)</option>
                        <option value="+41">+41 (Switzerland)</option>
                        <option value="+44">+44 (United Kingdom)</option>
                        <option value="+45">+45 (Denmark)</option>
                        <option value="+46">+46 (Sweden)</option>
                        <option value="+47">+47 (Norway)</option>
                        <option value="+48">+48 (Poland)</option>
                        <option value="+49">+49 (Germany)</option>
                        <option value="+51">+51 (Peru)</option>
                        <option value="+52">+52 (Mexico)</option>
                        <option value="+53">+53 (Cuba)</option>
                        <option value="+54">+54 (Argentina)</option>
                        <option value="+55">+55 (Brazil)</option>
                        <option value="+56">+56 (Chile)</option>
                        <option value="+57">+57 (Colombia)</option>
                        <option value="+58">+58 (Venezuela)</option>
                        <option value="+60">+60 (Malaysia)</option>
                        <option value="+61">+61 (Australia)</option>
                        <option value="+62">+62 (Indonesia)</option>
                        <option value="+63">+63 (Philippines)</option>
                        <option value="+64">+64 (New Zealand)</option>
                        <option value="+65">+65 (Singapore)</option>
                        <option value="+66">+66 (Thailand)</option>
                        <option value="+81">+81 (Japan)</option>
                        <option value="+82">+82 (South Korea)</option>
                        <option value="+84">+84 (Vietnam)</option>
                        <option value="+86">+86 (China)</option>
                        <option value="+90">+90 (Turkey)</option>
                        <option value="+92">+92 (Pakistan)</option>
                        <option value="+93">+93 (Afghanistan)</option>
                        <option value="+95">+95 (Myanmar)</option>
                        <option value="+211">+211 (South Sudan)</option>
                        <option value="+212">+212 (Morocco)</option>
                        <option value="+213">+213 (Algeria)</option>
                        <option value="+216">+216 (Tunisia)</option>
                        <option value="+218">+218 (Libya)</option>
                        <option value="+220">+220 (Gambia)</option>
                        <option value="+221">+221 (Senegal)</option>
                        <option value="+222">+222 (Mauritania)</option>
                        <option value="+223">+223 (Mali)</option>
                        <option value="+224">+224 (Guinea)</option>
                        <option value="+225">+225 (Ivory Coast)</option>
                        <option value="+226">+226 (Burkina Faso)</option>
                        <option value="+227">+227 (Niger)</option>
                        <option value="+228">+228 (Togo)</option>
                        <option value="+229">+229 (Benin)</option>
                        <option value="+230">+230 (Mauritius)</option>
                        <option value="+231">+231 (Liberia)</option>
                        <option value="+232">+232 (Sierra Leone)</option>
                        <option value="+233">+233 (Ghana)</option>
                        <option value="+234">+234 (Nigeria)</option>
                        <option value="+235">+235 (Chad)</option>
                        <option value="+236">+236 (Central African Republic)</option>
                        <option value="+237">+237 (Cameroon)</option>
                        <option value="+238">+238 (Cape Verde)</option>
                        <option value="+239">+239 (São Tomé and Príncipe)</option>
                        <option value="+240">+240 (Equatorial Guinea)</option>
                        <option value="+241">+241 (Gabon)</option>
                        <option value="+242">+242 (Congo)</option>
                        <option value="+243">+243 (DR Congo)</option>
                        <option value="+244">+244 (Angola)</option>
                        <option value="+245">+245 (Guinea-Bissau)</option>
                        <option value="+246">+246 (British Indian Ocean Territory)</option>
                        <option value="+248">+248 (Seychelles)</option>
                        <option value="+249">+249 (Sudan)</option>
                        <option value="+250">+250 (Rwanda)</option>
                        <option value="+251">+251 (Ethiopia)</option>
                        <option value="+252">+252 (Somalia)</option>
                        <option value="+253">+253 (Djibouti)</option>
                        <option value="+254">+254 (Kenya)</option>
                        <option value="+255">+255 (Tanzania)</option>
                        <option value="+256">+256 (Uganda)</option>
                        <option value="+257">+257 (Burundi)</option>
                        <option value="+258">+258 (Mozambique)</option>
                        <option value="+260">+260 (Zambia)</option>
                        <option value="+261">+261 (Madagascar)</option>
                        <option value="+262">+262 (Réunion)</option>
                        <option value="+263">+263 (Zimbabwe)</option>
                        <option value="+264">+264 (Namibia)</option>
                        <option value="+265">+265 (Malawi)</option>
                        <option value="+266">+266 (Lesotho)</option>
                        <option value="+267">+267 (Botswana)</option>
                        <option value="+268">+268 (Eswatini)</option>
                        <option value="+269">+269 (Comoros)</option>
                        <option value="+290">+290 (Saint Helena)</option>
                        <option value="+291">+291 (Eritrea)</option>
                        <option value="+297">+297 (Aruba)</option>
                        <option value="+298">+298 (Faroe Islands)</option>
                        <option value="+299">+299 (Greenland)</option>
                        <option value="+350">+350 (Gibraltar)</option>
                        <option value="+351">+351 (Portugal)</option>
                        <option value="+352">+352 (Luxembourg)</option>
                        <option value="+353">+353 (Ireland)</option>
                        <option value="+354">+354 (Iceland)</option>
                        <option value="+355">+355 (Albania)</option>
                        <option value="+356">+356 (Malta)</option>
                        <option value="+357">+357 (Cyprus)</option>
                        <option value="+358">+358 (Finland)</option>
                        <option value="+359">+359 (Bulgaria)</option>
                        <option value="+370">+370 (Lithuania)</option>
                        <option value="+371">+371 (Latvia)</option>
                        <option value="+372">+372 (Estonia)</option>
                        <option value="+373">+373 (Moldova)</option>
                        <option value="+374">+374 (Armenia)</option>
                        <option value="+375">+375 (Belarus)</option>
                        <option value="+376">+376 (Andorra)</option>
                        <option value="+377">+377 (Monaco)</option>
                        <option value="+378">+378 (San Marino)</option>
                        <option value="+379">+379 (Vatican City)</option>
                        <option value="+380">+380 (Ukraine)</option>
                        <option value="+381">+381 (Serbia)</option>
                        <option value="+382">+382 (Montenegro)</option>
                        <option value="+383">+383 (Kosovo)</option>
                        <option value="+385">+385 (Croatia)</option>
                        <option value="+386">+386 (Slovenia)</option>
                        <option value="+387">+387 (Bosnia and Herzegovina)</option>
                        <option value="+389">+389 (North Macedonia)</option>
                        <option value="+420">+420 (Czech Republic)</option>
                        <option value="+421">+421 (Slovakia)</option>
                        <option value="+423">+423 (Liechtenstein)</option>
                        <option value="+500">+500 (Falkland Islands)</option>
                        <option value="+501">+501 (Belize)</option>
                        <option value="+502">+502 (Guatemala)</option>
                        <option value="+503">+503 (El Salvador)</option>
                        <option value="+504">+504 (Honduras)</option>
                        <option value="+505">+505 (Nicaragua)</option>
                        <option value="+506">+506 (Costa Rica)</option>
                        <option value="+507">+507 (Panama)</option>
                        <option value="+508">+508 (Saint Pierre and Miquelon)</option>
                        <option value="+509">+509 (Haiti)</option>
                        <option value="+590">+590 (Guadeloupe)</option>
                        <option value="+591">+591 (Bolivia)</option>
                        <option value="+592">+592 (Guyana)</option>
                        <option value="+593">+593 (Ecuador)</option>
                        <option value="+594">+594 (French Guiana)</option>
                        <option value="+595">+595 (Paraguay)</option>
                        <option value="+596">+596 (Martinique)</option>
                        <option value="+597">+597 (Suriname)</option>
                        <option value="+598">+598 (Uruguay)</option>
                        <option value="+599">+599 (Netherlands Antilles)</option>
                        <option value="+670">+670 (East Timor)</option>
                        <option value="+672">+672 (Antarctica)</option>
                        <option value="+673">+673 (Brunei)</option>
                        <option value="+674">+674 (Nauru)</option>
                        <option value="+675">+675 (Papua New Guinea)</option>
                        <option value="+676">+676 (Tonga)</option>
                        <option value="+677">+677 (Solomon Islands)</option>
                        <option value="+678">+678 (Vanuatu)</option>
                        <option value="+679">+679 (Fiji)</option>
                        <option value="+680">+680 (Palau)</option>
                        <option value="+681">+681 (Wallis and Futuna)</option>
                        <option value="+682">+682 (Cook Islands)</option>
                        <option value="+683">+683 (Niue)</option>
                        <option value="+685">+685 (Samoa)</option>
                        <option value="+686">+686 (Kiribati)</option>
                        <option value="+687">+687 (New Caledonia)</option>
                        <option value="+688">+688 (Tuvalu)</option>
                        <option value="+689">+689 (French Polynesia)</option>
                        <option value="+690">+690 (Tokelau)</option>
                        <option value="+691">+691 (Micronesia)</option>
                        <option value="+692">+692 (Marshall Islands)</option>
                        <option value="+850">+850 (North Korea)</option>
                        <option value="+852">+852 (Hong Kong)</option>
                        <option value="+853">+853 (Macau)</option>
                        <option value="+855">+855 (Cambodia)</option>
                        <option value="+856">+856 (Laos)</option>
                        <option value="+880">+880 (Bangladesh)</option>
                        <option value="+886">+886 (Taiwan)</option>
                        <option value="+960">+960 (Maldives)</option>
                        <option value="+961">+961 (Lebanon)</option>
                        <option value="+962">+962 (Jordan)</option>
                        <option value="+963">+963 (Syria)</option>
                        <option value="+964">+964 (Iraq)</option>
                        <option value="+965">+965 (Kuwait)</option>
                        <option value="+966">+966 (Saudi Arabia)</option>
                        <option value="+967">+967 (Yemen)</option>
                        <option value="+968">+968 (Oman)</option>
                        <option value="+970">+970 (Palestine)</option>
                        <option value="+971">+971 (United Arab Emirates)</option>
                        <option value="+972">+972 (Israel)</option>
                        <option value="+973">+973 (Bahrain)</option>
                        <option value="+974">+974 (Qatar)</option>
                        <option value="+975">+975 (Bhutan)</option>
                        <option value="+976">+976 (Mongolia)</option>
                        <option value="+977">+977 (Nepal)</option>
                        <option value="+992">+992 (Tajikistan)</option>
                        <option value="+993">+993 (Turkmenistan)</option>
                        <option value="+994">+994 (Azerbaijan)</option>
                        <option value="+995">+995 (Georgia)</option>
                        <option value="+996">+996 (Kyrgyzstan)</option>
                        <option value="+998">+998 (Uzbekistan)</option>

                    </select>
                    <input type="tel" name="phone" placeholder="Numéro de téléphone" required>
                </div>
                <input type="text" name="license" placeholder="Numéro de permis de conduire" required>
                <button class="btn-anime" type="submit">S'inscrire</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form id="login-form">
                <h1>Connectez vous</h1>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Mot de passe" required>
                <a href="#">Mot de passe oublié?</a>
                <button class="btn-anime" type="submit">Connexion</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-bottom">
            <p>&copy; 2024 Mayar. Tous droits réservés.</p>
        </div>
    </footer>
    
    <script src="PageConnexion.js"></script>
</body>
</html>
