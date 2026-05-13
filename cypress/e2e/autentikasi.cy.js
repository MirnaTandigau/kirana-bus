describe('Pengujian Black Box - Modul Autentikasi', () => {

  // Skenario 1: Menguji keberhasilan registrasi akun baru
  it('Berhasil melakukan registrasi akun baru dengan data valid', () => {
    // Kunjungi halaman registrasi (menggunakan 127.0.0.1 sesuai terminal Anda)
    cy.visit('http://127.0.0.1:8000/register'); 

    const emailBaru = `pelanggan${Math.floor(Math.random() * 10000)}@test.com`; 
    
    cy.get('input[name="name"]').type('Pengguna Percobaan');
    cy.get('input[name="email"]').type(emailBaru);
    cy.get('input[name="password"]').type('password123');
    cy.get('input[name="password_confirmation"]').type('password123');

    cy.get('button[type="submit"]').click();

    // PERBAIKAN 1: Memastikan URL berubah ke halaman utama ('/') sesuai pengaturan web Anda
    cy.url().should('eq', 'http://127.0.0.1:8000/');
  });

  // Skenario 2: Menguji validasi form (Mengosongkan kolom email)
  it('Sistem menolak pendaftaran jika kolom email dikosongkan', () => {
    cy.visit('http://127.0.0.1:8000/register'); 

    // Sengaja tidak mengisi email
    cy.get('input[name="name"]').type('Pengguna Gagal');
    cy.get('input[name="password"]').type('password123');
    cy.get('input[name="password_confirmation"]').type('password123');

    cy.get('button[type="submit"]').click();

    // Memastikan tetap di halaman register
    cy.url().should('include', '/register');
    
    // PERBAIKAN 2: Mengecek pop-up validasi bawaan browser (HTML5 Required)
    // Cypress akan mengecek properti 'validationMessage' dari elemen input email
    cy.get('input[name="email"]')
      .invoke('prop', 'validationMessage')
      .should('include', 'Please fill out this field');
  });

});