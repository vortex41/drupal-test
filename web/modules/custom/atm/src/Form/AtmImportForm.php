<?php declare(strict_types=1);

namespace Drupal\atm\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a Atm form.
 */
final class AtmImportForm extends FormBase
{
  /**
   * {@inheritdoc}
   */
  public function getFormId(): string
  {
    return 'atm_import';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array
  {

    $form['file_import_content'] = [
      '#type' => 'container',
      '#attributes' => [],
      '#weight' => 0,
    ];

    $form['file_import_content']['atms_import_file'] = [
      '#title' => $this->t('Choose file to import'),
      '#type' => 'file',
      '#attributes' => ['accept' => 'text/csv'],
      '#description' => $this->t('Please provide CSV file'),
    ];

    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Send'),
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void
  {
    $allFiles = $this->getRequest()->files->get('files', []);
    if (empty($allFiles['atms_import_file'])) {
      // @todo Add error message to the field.
      return;
    }
    /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $fileUpload */
    $fileUpload = $allFiles['atms_import_file'];

    // @todo Validate the form here.
    if (!$fileUpload->isValid()) {
      // @todo Add error message to the field.
      return;
    }

    $fileContent = file_get_contents($fileUpload->getRealPath());

    // @todo Check if file is indeed a CSV file
    $isValidCsv = false;
    if (!$isValidCsv) {
      // @todo Add error message to the field.
      return;
    }

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void
  {
    $allFiles = $this->getRequest()->files->get('files', []);
    /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $fileUpload */
    $fileUpload = $allFiles['atms_import_file'];
    $fileContent = file_get_contents($fileUpload->getRealPath());

    $this->importAtmsFromFile($fileContent);
  }

  protected function importAtmsFromFile(string $fileContent): void
  {
    // @todo Implement the import logic here.
  }

}
