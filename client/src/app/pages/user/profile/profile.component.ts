import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { AuthService } from 'src/app/services/auth.service';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.scss'],
})
export class ProfileComponent implements OnInit {
  user: any;
  currentUser = false;

  constructor(
    private route: ActivatedRoute,
    private userService: UserService,
    private router: Router,
    private auth: AuthService
  ) {}

  ngOnInit(): void {
    let slug = this.route.snapshot.paramMap.get('slug');

    if (slug) {
      this.userService.get(slug).subscribe((response: any) => {
        this.user = response.data;
        if (this.auth.getUser().slug === this.user.slug) {
          this.currentUser = true;
        }
      });
    } else {
      this.router.navigateByUrl('/');
    }
  }
}
