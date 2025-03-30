<?php
class ProductView {
    private $basePath;

    public function __construct($basePath = '../Views/products/') {
        $this->basePath = $basePath;
    }

    public function mostrarStatus($data) {
        $status = isset($data['status']) ? $data['status'] : 'error';
        $message = isset($data['message']) ? $data['message'] : 'Error desconocido';
        
        // Plantilla HTML reusable con estilos Bootstrap
        return '
        <div class="alert alert-' . ($status === 'success' ? 'success' : 'danger') . '">
            <h4 class="alert-heading">' . strtoupper($status) . '</h4>
            <p class="mb-0">' . htmlspecialchars($message) . '</p>
        </div>';
    }

    public function mostrarEdit($producto, $error = null) {
        $this->renderTemplate('product-edit.php', [
            'producto' => $producto,
            'error' => $error
        ]);
    }

    public function mostrarListaCompleta($productos) {
      ob_start();
      ?>
      <table class="table table-bordered table-sm">
          <thead>
              <tr>
                  <td>Id</td>
                  <td>Nombre</td>
                  <td>Descripción</td>
                  <td>Acciones</td>
              </tr>
          </thead>
          <tbody>
              <?php foreach ($productos as $producto): ?>
              <tr productId="<?= $producto['id'] ?>">
                  <td><?= $producto['id'] ?></td>
                  <td>
                      <a href="#" class="product-item"><?= htmlspecialchars($producto['nombre']) ?></a>
                  </td>
                  <td><?= htmlspecialchars($producto['detalles']) ?></td>
                  <td>
                      <button class="product-delete btn btn-danger">
                          Eliminar
                      </button>
                  </td>
              </tr>
              <?php endforeach; ?>
          </tbody>
      </table>
      <?php
      return ob_get_clean();
  }

  public function buscarProducto($productos) {
    ob_start();
    ?>
    <div class="card my-4 d-block" id="product-result">
        <div class="card-body">
            <ul id="container">
                <?php if(count($productos) > 0): ?>
                    <?php foreach($productos as $producto): ?>
                        <li><?= htmlspecialchars($producto['nombre']) ?></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>No se encontraron productos</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    
    <table class="table table-bordered table-sm">
        <tbody id="products">
            <?php if(count($productos) > 0): ?>
                <?php foreach($productos as $producto): ?>
                    <tr productId="<?= $producto['id'] ?>">
                        <td><?= $producto['id'] ?></td>
                        <td><?= htmlspecialchars($producto['nombre']) ?></td>
                        <td>
                            <ul>
                                <li>precio: <?= $producto['precio'] ?></li>
                                <li>unidades: <?= $producto['unidades'] ?></li>
                                <li>modelo: <?= htmlspecialchars($producto['modelo']) ?></li>
                                <li>marca: <?= htmlspecialchars($producto['marca']) ?></li>
                                <li>detalles: <?= htmlspecialchars($producto['detalles']) ?></li>
                            </ul>
                        </td>
                        <td>
                            <button class="product-delete btn btn-danger">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No se encontraron resultados</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php
    return ob_get_clean();
}

public function mostrarSugerencias($productos, $nombreIngresado) {
  ob_start();
  ?>
  <div id="suggestions" class="suggestions-container">
      <?php if(!empty($productos)): ?>
          <ul>
              <?php foreach($productos as $producto): ?>
                  <?php if($producto['nombre'] !== $nombreIngresado): ?>
                      <li class="suggestion-item">
                          <?= htmlspecialchars($producto['nombre']) ?>
                      </li>
                  <?php else: ?>
                      <li class="suggestion-item text-danger">
                          <i class="fas fa-exclamation-circle"></i> El nombre ya existe
                      </li>
                  <?php endif; ?>
              <?php endforeach; ?>
          </ul>
      <?php else: ?>
          <p class="text-muted">Sin coincidencias</p>
      <?php endif; ?>
  </div>
  <?php
  return ob_get_clean();
}

    public function mostrarSingle($producto) {
      ob_start();
      ?>
      <script type="application/json" id="single-product-data">
          <?= json_encode($producto, JSON_HEX_TAG | JSON_HEX_APOS | JSON_UNESCAPED_UNICODE) ?>
      </script>
      <?php
      return ob_get_clean();
  }


    private function renderTemplate($template, $data = []) {
        extract($data);
        require $this->basePath . $template;
    }
}
?>