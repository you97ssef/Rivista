import { Component, OnInit } from '@angular/core';
import { ToastrService } from 'ngx-toastr';
import { AuthService } from 'src/app/services/auth.service';

@Component({
  selector: 'app-resend-verification-email',
  templateUrl: './resend-verification-email.component.html',
  styleUrls: ['./resend-verification-email.component.scss'],
})
export class ResendVerificationEmailComponent implements OnInit {

  constructor(
    private authService: AuthService,
    private toastr: ToastrService
  ) {}

  ngOnInit(): void {}

  resendVerificationEmail() {
    this.authService.sendEmailVerification().subscribe((response: any) => {
      this.toastr.success(response.message);
    });
  }
}
