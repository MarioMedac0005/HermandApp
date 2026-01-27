<!doctype html>
<html>
  <body style="font-family: Arial, sans-serif;">
    <h2>Nuevo registro recibido desde el front</h2>

    <h3>Tipo de organización</h3>
    <p><strong>{{ $data['orgType'] }}</strong></p>

    <h3>Cuenta</h3>
    <ul>
      <li><strong>Nombre:</strong> {{ $data['account']['firstName'] }}</li>
      <li><strong>Apellidos:</strong> {{ $data['account']['lastName'] }}</li>
      <li><strong>Email:</strong> {{ $data['account']['email'] }}</li>
    </ul>

    <h3>Organización</h3>
    <ul>
      <li><strong>Nombre:</strong> {{ $data['organization']['name'] }}</li>
      <li><strong>Ciudad:</strong> {{ $data['organization']['city'] }}</li>
      <li><strong>NIF/CIF:</strong> {{ $data['organization']['nifCif'] }}</li>
      <li><strong>Email organización:</strong> {{ $data['organization']['email'] }}</li>

      @if(!empty($data['organization']['phone']))
        <li><strong>Teléfono:</strong> {{ $data['organization']['phone'] }}</li>
      @endif

      @if(!empty($data['organization']['canonicalSeat']))
        <li><strong>Sede canónica:</strong> {{ $data['organization']['canonicalSeat'] }}</li>
      @endif

      @if(!empty($data['organization']['rehearsalPlace']))
        <li><strong>Sitio de ensayo:</strong> {{ $data['organization']['rehearsalPlace'] }}</li>
      @endif

      @if(!empty($data['organization']['description']))
        <li><strong>Descripción:</strong> {{ $data['organization']['description'] }}</li>
      @endif
    </ul>

    <hr />
    <p style="color:#666; font-size: 12px;">
      Este correo se envía para revisar qué datos hay que crear en backend.
    </p>
  </body>
</html>
