import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { ToastrService } from 'ngx-toastr';
import { UserRole } from 'src/app/enums/UserRole';
import { AuthService } from 'src/app/services/auth.service';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.scss'],
})
export class ProfileComponent implements OnInit {
  roles = [
    { value: UserRole.Admin, name: 'Admin' },
    { value: UserRole.User, name: 'User' },
  ];
  user: any;
  currentUser = false;
  isAdmin = false;
  userRole: any;
  changedUser = false;

  constructor(
    private route: ActivatedRoute,
    private userService: UserService,
    private router: Router,
    private auth: AuthService,
    private toastr: ToastrService,
  ) {}

  ngOnInit(): void {
    let slug = this.route.snapshot.paramMap.get('slug');

    if (slug) {
      let user = this.auth.getUser();
      if (user && user.role == UserRole.Admin) this.isAdmin = true;

      this.userService.get(slug).subscribe((response: any) => {
        this.user = response.data;
        this.userRole = this.user.role;

        if (user.slug === this.user.slug) {
          this.currentUser = true;
          this.isAdmin = false;
        }
      });
    } else {
      this.router.navigateByUrl('/');
    }
  }

  changeRole() {
    this.userService
      .changeRole({ user_id: this.user.id, role: this.userRole })
      .subscribe(() => {
        this.toastr.success('Role changed successfully');
      });
  }
}
