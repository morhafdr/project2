<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>مرحباً بك في الشركة!</title>
</head>
<body>
<h1>مرحباً، {{ $firstName }} {{ $lastName }}</h1>

<p>نحن متحمسون لانضمامك إلى فريقنا! إليك تفاصيلك:</p>

<ul>
    <li>البريد الإلكتروني: {{ $email }}</li>
    <li>رقم الهاتف: {{ $phone }}</li>
    <li>المكتب: {{ $office->city }}/{{ $office->address }}</li>
    <li>تاريخ الانضمام: {{ $joinDate }}</li>
    <li>كلمة المرور: {{ $password }}</li>
</ul>

<p>إذا كان لديك أي أسئلة، فلا تتردد في التواصل معنا.</p>

<p>مع أطيب التحيات،</p>

</body>
</html>
