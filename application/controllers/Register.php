<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{
    public function index()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="form-error">', '</p>');

        $this->load->view('static/header');
        $this->load->view('register');
        $this->load->view('static/footer');
    }

    //Ova funkcija se poziva klikom na gumb za registraciju
    public function done()
    {
        //Učitavanje biblioteke za provjeru valjanosti forme, te modela "Korisnik" koji komunicira sa bazom
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="form-error">', '</p>');
        $this->load->model('korisnik', '', true);

        //Postavljanje pravila za provjeru valjanosti forme i error poruka
        $this->form_validation->set_rules(
            'ime',
            'Ime',
            'trim|required|max_length[20]',
            array('required'=>'Unesite ime', 'max_length'=>'Ime ne može sadržavati više od 20 znakova.')
        );
        $this->form_validation->set_rules(
            'prezime',
            'Prezime',
            'trim|required|max_length[20]',
            array('required'=>'Unesite prezime', 'max_length'=>'Prezime ne može sadržavati više od 20 znakova.')
        );
        $this->form_validation->set_rules(
            'email',
            'Email',
            'trim|required|max_length[40]|valid_email|is_unique[korisnik.email]',
            array('required'=>'Unesite email adresu.', 'max_length'=>'Email ne može sadržavati više od 40 znakova.', 'valid_email'=>'Unesena email adresa nije ispravna.',
            'is_unique'=>'Korisnički račun sa unesenom email adresom već postoji.')
        );
        $this->form_validation->set_rules(
            'mailconf',
            'Potvrda emaila',
            'required|matches[email]',
            array('required'=>'Potvrdite email.','matches'=>'Email adrese se ne podudaraju.')
        );
        $this->form_validation->set_rules(
            'lozinka',
            'Lozinka',
            'required',
            array('required'=>'Unesite lozinku.')
        );
        $this->form_validation->set_rules(
            'passconf',
            'Potvrda lozinke',
            'required|matches[lozinka]',
            array('required'=>'Potvrdite lozinku.', 'matches'=>'Lozinke se ne podudaraju.')
        );

        if ($this->form_validation->run() == false) {
            $this->load->view('static/header');
            $this->load->view('register');
            $this->load->view('static/footer');
        } else {
            $this->load->view('static/header');
            $this->load->view('register_success');
            $this->load->view('static/footer');
            $this->korisnik->dodaj();
        }
    }
}